# How to Push to Git Branch (Excluding database.sqlite)

## Step 1: Initialize Git Repository (if not already done)

```powershell
git init
```

## Step 2: Verify database.sqlite is Ignored

The `.gitignore` file already contains `database/database.sqlite`, so it will be automatically excluded.

Check if it's ignored:
```powershell
git check-ignore database/database.sqlite
```

If it returns the path, it's being ignored correctly.

## Step 3: Add All Files (database.sqlite will be automatically excluded)

```powershell
git add .
```

This will add all files EXCEPT those listed in `.gitignore` (including `database.sqlite`).

## Step 4: Check What Will Be Committed

```powershell
git status
```

Verify that `database.sqlite` is NOT in the list of files to be committed.

## Step 5: Commit Your Changes

```powershell
git commit -m "Initial commit: MySQL setup and all features"
```

Or use a more descriptive message:
```powershell
git commit -m "Setup MySQL database, configure all features, and update project structure"
```

## Step 6: Create and Switch to a Branch (Optional)

If you want to work on a specific branch:

```powershell
# Create and switch to a new branch
git checkout -b main

# Or if you want to use a different branch name
git checkout -b develop
```

## Step 7: Add Remote Repository

If you haven't added a remote repository yet:

```powershell
# For GitHub
git remote add origin https://github.com/yourusername/dorminex.git

# Or for GitLab
git remote add origin https://gitlab.com/yourusername/dorminex.git
```

## Step 8: Push to Remote Branch

```powershell
# Push to main branch
git push -u origin main

# Or if your default branch is master
git push -u origin master

# Or push to a specific branch
git push -u origin develop
```

## Quick One-Liner Commands

### For First Time Setup:
```powershell
git init
git add .
git commit -m "Initial commit"
git branch -M main
git remote add origin https://github.com/yourusername/dorminex.git
git push -u origin main
```

### For Subsequent Pushes:
```powershell
git add .
git commit -m "Your commit message"
git push
```

## Verify database.sqlite is NOT in Git

After pushing, verify that `database.sqlite` is not tracked:

```powershell
# Check if database.sqlite is tracked
git ls-files | findstr database.sqlite

# Should return nothing (empty)
```

## Files That Will Be Excluded (from .gitignore)

These files are automatically excluded:
- `database/database.sqlite` ✅
- `.env` files
- `vendor/` directory
- `node_modules/` directory
- Log files (`*.log`)
- Cache files
- And more...

## Troubleshooting

### If database.sqlite was already tracked before adding to .gitignore:

```powershell
# Remove from git cache (but keep the file locally)
git rm --cached database/database.sqlite
git commit -m "Remove database.sqlite from git tracking"
git push
```

### Check what files are being tracked:
```powershell
git ls-files
```

### See what's ignored:
```powershell
git status --ignored
```

## Best Practices

1. **Always check before committing:**
   ```powershell
   git status
   ```

2. **Use meaningful commit messages:**
   ```powershell
   git commit -m "Add MySQL setup scripts and configuration"
   ```

3. **Push regularly:**
   ```powershell
   git add .
   git commit -m "Update feature X"
   git push
   ```

4. **Create branches for features:**
   ```powershell
   git checkout -b feature/mysql-setup
   # Make changes
   git add .
   git commit -m "Add MySQL setup"
   git push -u origin feature/mysql-setup
   ```

