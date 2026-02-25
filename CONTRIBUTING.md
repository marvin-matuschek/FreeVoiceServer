# Contributing to FreeVoiceServer

We welcome contributions! Whether you’re fixing a bug, adding a feature, or improving documentation, your help is appreciated.  

This guide explains how to get started with development and submit your changes.

---

## 1. Fork & Clone

1. Fork the repository on GitHub.  
2. Clone your fork locally:

```bash
git clone https://github.com/<your-username>/FreeVoiceServer.git
cd FreeVoiceServer
```

3. Add the upstream repository (optional, to keep your fork up-to-date):

```bash
git remote add upstream https://github.com/<original-org>/FreeVoiceServer.git
```

---

## 2. Development Setup

FreeVoiceServer is a **Symfony project running with Docker**.

1. Start Docker containers:

```bash
docker-compose up -d
```

2. Access the app container:

```bash
docker exec -it free-voice-server-app bash
```

3. Install PHP dependencies inside the container using Composer:

```bash
composer install
```

4. Run Symfony commands as needed inside the container:

```bash
php bin/console <command>
```

> Currently, no database setup is required.

---

## 3. Creating a Branch

- Branches should be created from `main`:

```bash
git checkout main
git pull upstream main
git checkout -b feature/my-own-branch
```
---

## 4. Submitting a Pull Request

1. Push your branch to your fork:

```bash
git push origin feature/my-own-branch
```

2. Open a **Pull Request** against the `main` branch.  
3. Include the **reason for your changes**:

> Describe **why** the changes are needed, not just what they do.  

4. After submission, maintainers will review your PR and may request changes.

---

## 5. Future Notes

- PHP-CS-Fixer for code formatting will be introduced in the future.  
- PHPStan will be used in the future to improve static analysis and code quality.  
- Writing tests is **not mandatory for now**, but PHPUnit tests will be required in the future.  
- Contributions that improve tests, documentation, or code quality are highly appreciated.

---

## 6. Thank You

Your contributions make FreeVoiceServer better and more open. Thank you for helping us build a free, decentralized communication platform.
