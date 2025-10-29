# 🚀 Deploy to Render (Free Tier)

## Prerequisites
- GitHub account
- Render account (sign up at https://render.com - it's free!)
- Your code pushed to GitHub

## Step-by-Step Deployment Guide

### Step 1: Push Your Code to GitHub

If you haven't already, push your code to GitHub:

```bash
# Initialize git (if not already done)
git init

# Add all files
git add .

# Commit
git commit -m "Initial commit - Ticket Management App"

# Create a new repository on GitHub, then:
git remote add origin https://github.com/YOUR_USERNAME/YOUR_REPO_NAME.git
git branch -M main
git push -u origin main
```

### Step 2: Sign Up for Render

1. Go to https://render.com
2. Click **"Get Started for Free"**
3. Sign up with your GitHub account (recommended for easy deployment)

### Step 3: Create a New Web Service

1. From your Render Dashboard, click **"New +"** → **"Web Service"**
2. Click **"Connect account"** to link your GitHub account (if not already done)
3. Find and select your repository from the list
4. Click **"Connect"**

### Step 4: Configure Your Web Service

Fill in the following settings:

**Basic Settings:**
- **Name**: `twig-ticket-app` (or any name you prefer)
- **Region**: Choose the closest to you (e.g., Oregon, Frankfurt, Singapore)
- **Branch**: `main` (or your default branch)
- **Root Directory**: Leave blank (unless your app is in a subdirectory)

**Build & Deploy Settings:**
- **Runtime**: Select **"Docker"** (Render will auto-detect the Dockerfile)
- **Build Command**: Leave blank (Docker handles this)
- **Start Command**: Leave blank (uses CMD from Dockerfile)

**Instance Type:**
- Select **"Free"** (this gives you 750 hours/month free)

### Step 5: Environment Variables (Optional)

If you need any environment variables, add them in the "Environment" section:
- Click **"Add Environment Variable"**
- Example: `APP_ENV` = `production`

### Step 6: Deploy!

1. Click **"Create Web Service"** at the bottom
2. Render will automatically:
   - Clone your repository
   - Run `composer install`
   - Start your PHP server
   - Assign you a free `.onrender.com` URL

3. Wait 2-5 minutes for the first build to complete
4. Once it shows **"Live"** in green, click your app URL!

## Your App is Now Live! 🎉

You'll get a URL like: `https://twig-ticket-app.onrender.com`

## Important Notes About Free Tier

### ⚠️ Free Tier Limitations:

1. **Spins Down After Inactivity**: 
   - Your app will sleep after 15 minutes of no activity
   - First request after sleep takes ~30 seconds to "wake up"
   - Subsequent requests are fast

2. **750 Hours/Month**: 
   - That's ~31 days if your app runs 24/7
   - Multiple apps share this limit

3. **No Persistent Storage**:
   - Files written to disk (like `data/tickets.json`) will be lost when the service restarts
   - **Solution**: Use a free database instead (see upgrade section below)

## 🔄 Automatic Deployments

Every time you push to your GitHub repository, Render will automatically:
1. Pull the latest code
2. Run the build command
3. Restart your service

To trigger a manual deployment:
- Go to your Render dashboard
- Click your service
- Click **"Manual Deploy"** → **"Deploy latest commit"**

## 🗄️ Upgrade: Add Persistent Storage (Recommended)

Since `tickets.json` won't persist on the free tier, here are free alternatives:

### Option 1: Use Render PostgreSQL (Free)

1. Create a free PostgreSQL database on Render
2. Update your app to use the database instead of JSON files
3. Render gives you a free 256MB PostgreSQL database

### Option 2: Use MongoDB Atlas (Free)

1. Sign up at https://www.mongodb.com/cloud/atlas
2. Create a free cluster (512MB)
3. Get your connection string
4. Add it as an environment variable on Render
5. Update your app to use MongoDB

### Option 3: Use Railway PostgreSQL (Free Alternative Platform)

Railway also has a generous free tier with persistent storage.

## 🐛 Debugging Deployment Issues

### View Logs:
1. Go to your service in Render dashboard
2. Click the **"Logs"** tab
3. You'll see real-time logs of your application

### Common Issues:

**"Build failed"**:
- Check that `composer.json` is in your repository root
- Ensure all PHP files are committed

**"Application Error"**:
- Check logs for PHP errors
- Verify your `composer install` ran successfully

**"404 Not Found"**:
- Make sure `index.php` is in your root directory
- Check that the Router is properly configured

## 📝 Test Credentials

Use these credentials to test your deployed app:

**Admin User:**
- Email: `admin@ticketapp.com`
- Password: `admin123`

**Demo User:**
- Email: `user@ticketapp.com`
- Password: `user123`

## 🎯 Next Steps

1. **Custom Domain**: Render allows you to add a custom domain (even on free tier)
2. **HTTPS**: Automatically enabled on all Render deployments
3. **Environment Variables**: Add secrets in the Render dashboard
4. **Scaling**: Upgrade to paid tier for always-on service and more resources

## 📚 Useful Links

- [Render PHP Docs](https://render.com/docs/deploy-php)
- [Render Free Tier Details](https://render.com/docs/free)
- [Your Render Dashboard](https://dashboard.render.com/)

## ❓ Need Help?

- Check Render's [Community Forum](https://community.render.com/)
- View [Render Status](https://status.render.com/) for any outages
- Check your deployment logs on the Render dashboard

---

**Happy Deploying! 🚀**
