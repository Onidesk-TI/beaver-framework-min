#!/usr/bin/env python3
"""
Beaver Framework — Instalador.
Uso:
  python3 beaver-installer.py [pasta]
  python3 beaver-installer.py --repo Onidesk-TI/beaver-min --yes
  python3 beaver-installer.py --help
"""
import argparse
import base64
import io
import os
import re
import secrets
import shutil
import subprocess
import sys
import tarfile
import urllib.request

# ─── Cores ───
if sys.stdout.isatty() and os.name != "nt":
    B, R = "\033[1m", "\033[0m"
    G, Y, RD, C = "\033[32m", "\033[33m", "\033[31m", "\033[36m"
else:
    B = R = G = Y = RD = C = ""

def ok(m):   print(f"  {G}✓{R} {m}")
def err(m):  print(f"  {RD}✗{R} {m}", file=sys.stderr)
def warn(m): print(f"  {Y}⚠{R} {m}")
def info(m): print(f"  {C}→{R} {m}")

REPOS = {
    "framework": "Onidesk-TI/beaver-framework",
    "min":       "Onidesk-TI/beaver-min",
}

def run(cmd, cwd=None, timeout=180):
    try:
        r = subprocess.run(cmd, shell=True, capture_output=True,
                          text=True, timeout=timeout, cwd=cwd)
        return r.returncode == 0, (r.stdout + r.stderr).strip()
    except subprocess.TimeoutExpired:
        return False, "timeout"
    except Exception as e:
        return False, str(e)

def has(cmd):
    return shutil.which(cmd) is not None

def php_ver():
    if not has("php"):
        return None
    try:
        out = subprocess.check_output(["php", "-r", "echo PHP_VERSION;"],
                                       stderr=subprocess.DEVNULL).decode().strip()
        return tuple(int(x) for x in out.split(".")[:2])
    except Exception:
        return None

def php_ext(ext):
    if not has("php"):
        return False
    try:
        out = subprocess.check_output(["php", "-m"],
                                       stderr=subprocess.DEVNULL).decode().lower()
        return ext.lower() in out
    except Exception:
        return False

# ══════════════════════════════════════════════════════════
def cmd_install(args):
    target = os.path.abspath(os.path.expanduser(args.target))

    print(f"\n{B}🦫  Beaver Framework — Instalador{R}")
    print("═" * 50)
    print(f"  Destino: {target}")

    # 1. Pasta
    if os.path.exists(target):
        if os.listdir(target) and not args.force:
            err(f"{target} já existe e não está vazia. Usa --force para sobrescrever.")
            sys.exit(1)
    else:
        os.makedirs(target, exist_ok=True)

    # 2. Requisitos
    print(f"\n{B}Requisitos{R}")
    print("─" * 50)

    v = php_ver()
    checks = [
        ("PHP",              v is not None),
        ("PHP >= 8.1",       v is not None and v >= (8, 1)),
        ("PHP pdo_sqlite",   php_ext("pdo_sqlite")),
        ("PHP mbstring",     php_ext("mbstring")),
        ("PHP openssl",      php_ext("openssl")),
        ("PHP json",         php_ext("json")),
        ("curl",             has("curl")),
        ("tar",              has("tar")),
        ("composer",         has("composer")),
    ]
    missing = 0
    for name, o in checks:
        if o: ok(name)
        else:
            err(name); missing += 1

    if missing:
        err(f"\nFaltam {missing} requisito(s). Instala e tenta de novo.")
        sys.exit(1)

    # 3. Download
    repo = REPOS[args.variant] if args.variant in REPOS else args.repo
    print(f"\n{B}Download{R}")
    print("─" * 50)
    info(f"A descarregar {repo}@{args.branch}...")

    url = f"https://github.com/{repo}/archive/refs/heads/{args.branch}.tar.gz"
    try:
        with urllib.request.urlopen(url, timeout=60) as r:
            data = r.read()
    except Exception as e:
        err(f"Download falhou: {e}")
        sys.exit(1)

    ok(f"Descarregado ({len(data)/1024/1024:.1f} MB)")

    # 4. Extrair
    info("A extrair...")
    with tarfile.open(fileobj=io.BytesIO(data), mode="r:gz") as tar:
        for m in tar.getmembers():
            parts = m.name.split("/", 1)
            if len(parts) < 2:
                continue
            m.name = parts[1]
            tar.extract(m, target)
    ok("Extraído")

    # 5. Composer
    if not os.path.isfile(os.path.join(target, "vendor/autoload.php")):
        info("composer install...")
        okc, out = run("composer install --no-dev --optimize-autoloader", cwd=target, timeout=300)
        if not okc:
            err(f"composer falhou: {out}")
            sys.exit(1)
        ok("Composer instalado")
    else:
        ok("vendor/ já incluído")

    # 6. .env
    env = os.path.join(target, ".env")
    if not os.path.isfile(env):
        example = os.path.join(target, ".env.example")
        if os.path.isfile(example):
            shutil.copy(example, env)
        else:
            with open(env, "w") as f:
                f.write(
                    "APP_NAME=Beaver\nAPP_ENV=local\nAPP_DEBUG=true\n"
                    "APP_URL=http://localhost:9000\nAPP_KEY=\n\n"
                    f"DB_CONNECTION=sqlite\nDB_DATABASE={target}/database/database.sqlite\n\n"
                    "MAIL_DRIVER=log\nCACHE_DRIVER=file\n"
                )
        key = base64.b64encode(secrets.token_bytes(32)).decode()
        with open(env) as f:
            content = f.read()
        content = re.sub(r"^APP_KEY=.*$", f"APP_KEY={key}", content, flags=re.M)
        with open(env, "w") as f:
            f.write(content)
        os.chmod(env, 0o600)
        ok(".env + APP_KEY")

    # 7. SQLite
    os.makedirs(os.path.join(target, "database"), exist_ok=True)
    dbf = os.path.join(target, "database/database.sqlite")
    if not os.path.isfile(dbf):
        open(dbf, "a").close()
        os.chmod(dbf, 0o666)
        ok("SQLite criado")

    # 8. Permissões
    if os.path.isdir(os.path.join(target, "storage")):
        run(f"chmod -R u+rwX,g+rwX {os.path.join(target, 'storage')}")
        ok("Permissões storage")

    # 9. Done
    print()
    print("═" * 50)
    print(f"{B}{G}✓ Instalação concluída{R}")
    print("═" * 50)
    print(f"\n  Pasta: {target}")
    print(f"\n  {B}Arrancar:{R}")
    print(f"    cd {target}")
    print(f"    php -S localhost:9000 -t public public/router.php")
    print(f"\n  {B}Abrir:{R}")
    print(f"    http://localhost:9000\n")

def cmd_doctor(args):
    """Verifica se o PC tem tudo para correr Beaver."""
    print(f"\n{B}🦫  Beaver — diagnóstico{R}")
    print("═" * 50)

    v = php_ver()
    items = [
        ("PHP",              has("php"),               "Instala PHP 8.1+"),
        ("PHP >= 8.1",       v is not None and v >= (8, 1), "Actualiza PHP"),
        ("PHP pdo_sqlite",   php_ext("pdo_sqlite"),    "apt install php-sqlite3"),
        ("PHP mbstring",     php_ext("mbstring"),      "apt install php-mbstring"),
        ("PHP openssl",      php_ext("openssl"),       "apt install php-openssl"),
        ("PHP json",         php_ext("json"),          "apt install php-json"),
        ("curl",             has("curl"),              "apt install curl"),
        ("tar",              has("tar"),               "apt install tar"),
        ("git",              has("git"),               "apt install git"),
        ("composer",         has("composer"),          "https://getcomposer.org"),
    ]
    for name, o, hint in items:
        if o: ok(name)
        else: err(f"{name}  →  {hint}")

    print()

def main():
    parser = argparse.ArgumentParser(
        prog="beaver-installer",
        description="Instalador do Beaver Framework",
        formatter_class=argparse.RawDescriptionHelpFormatter,
        epilog="""
Exemplos:
  python3 beaver-installer.py                    instala em ./beaver
  python3 beaver-installer.py ~/site             instala em ~/site
  python3 beaver-installer.py ~/site --variant min
  python3 beaver-installer.py --doctor           verifica requisitos
  python3 beaver-installer.py --yes ~/site       não pede confirmação
        """,
    )
    parser.add_argument("target", nargs="?", default="./beaver",
                       help="pasta de instalação (default: ./beaver)")
    parser.add_argument("--variant", choices=["framework", "min"], default="framework",
                       help="variante a instalar (default: framework)")
    parser.add_argument("--repo", default=None,
                       help="repo custom (sobrepõe --variant)")
    parser.add_argument("--branch", default="main")
    parser.add_argument("--force", action="store_true",
                       help="sobrescrever pasta existente")
    parser.add_argument("--doctor", action="store_true",
                       help="só verificar requisitos, não instalar")
    parser.add_argument("--version", action="version", version="beaver-installer 1.0.0")

    args = parser.parse_args()

    if args.doctor:
        cmd_doctor(args)
        return

    # Confirmação interactiva (a menos que --yes ou --force)
    if not args.force and not os.environ.get("BEAVER_YES"):
        print(f"\n{B}Instalar {args.variant} em:{R} {os.path.abspath(args.target)}")
        try:
            r = input("Continuar? [S/n] ").strip().lower()
        except (KeyboardInterrupt, EOFError):
            print("\nCancelado.")
            sys.exit(130)
        if r and r != "s":
            print("Cancelado.")
            sys.exit(0)

    cmd_install(args)

if __name__ == "__main__":
    try:
        main()
    except KeyboardInterrupt:
        print("\n\nCancelado.")
        sys.exit(130)
