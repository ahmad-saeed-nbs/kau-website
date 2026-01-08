# Laravel CI/CD Pipeline Deployment Guide

This guide walks you through setting up a complete CI/CD pipeline for your Laravel application using AWS services and GitHub Actions.

## Architecture Overview

```
GitHub → GitHub Actions → AWS CodePipeline → AWS CodeBuild → Amazon ECR
```

**Key Components:**
- **GitHub Actions**: Runs tests, security scans, and triggers AWS pipeline
- **AWS CodePipeline**: Orchestrates the deployment workflow
- **AWS CodeBuild**: Builds and pushes Docker images
- **Amazon ECR**: Stores container images with proper tagging

## Prerequisites

1. **AWS Account** with appropriate permissions
2. **GitHub Repository** with your Laravel code
3. **AWS CLI** configured locally
4. **GitHub Personal Access Token** with repo permissions

## Quick Start

### 1. Deploy Infrastructure

```bash
# Make the deployment script executable
chmod +x scripts/deploy.sh

# Deploy to production
./scripts/deploy.sh production us-east-1 YOUR_GITHUB_USERNAME YOUR_REPO_NAME main
```

### 2. Configure GitHub Token

```bash
# Update the GitHub token secret
aws secretsmanager update-secret \
  --secret-id github-token \
  --secret-string '{"token":"YOUR_GITHUB_PERSONAL_ACCESS_TOKEN"}' \
  --region us-east-1
```

### 3. Configure GitHub Secrets

Add these secrets to your GitHub repository:

```
AWS_ACCESS_KEY_ID=your_access_key
AWS_SECRET_ACCESS_KEY=your_secret_key
```

### 4. Push Code

Push your code to the main branch to trigger the pipeline:

```bash
git add .
git commit -m "Initial deployment setup"
git push origin main
```

## Image Tagging Strategy

The pipeline creates multiple tags for each build:

- **`latest`**: Always points to the most recent main branch build
- **`v1.2.3`**: Semantic version tags (when you create GitHub releases)
- **`main-abc1234`**: Branch name + commit hash
- **`abc1234`**: Short commit hash

## Pipeline Stages

### GitHub Actions Workflow

1. **Test Stage**
   - Runs PHPUnit tests
   - Generates code coverage
   - Tests against MySQL and Redis

2. **Security Scan**
   - Scans code for vulnerabilities
   - Uploads results to GitHub Security tab

3. **Build & Push**
   - Builds optimized Docker image
   - Pushes to ECR with multiple tags
   - Scans final image for vulnerabilities

### AWS CodePipeline

1. **Source**: Pulls code from GitHub
2. **Build**: Uses CodeBuild to create and push Docker images

## Docker Optimization

The `Dockerfile.optimized` includes:

- **Multi-stage build** for smaller final image
- **Non-root user** for security
- **Health checks** for container monitoring
- **Optimized PHP extensions** and dependencies
- **Asset building** with Node.js

## Monitoring & Troubleshooting

### Check Pipeline Status

```bash
# View pipeline executions
aws codepipeline list-pipeline-executions --pipeline-name laravel-app-production-pipeline

# Get detailed execution info
aws codepipeline get-pipeline-execution --pipeline-name laravel-app-production-pipeline --pipeline-execution-id <execution-id>
```

### View ECR Images

```bash
# List all images
aws ecr list-images --repository-name laravel-app-production

# Get image details
aws ecr describe-images --repository-name laravel-app-production
```

### CodeBuild Logs

```bash
# View build logs
aws logs describe-log-groups --log-group-name-prefix /aws/codebuild/laravel-app
```

## Environment Variables

Configure these in your deployment environment:

```bash
APP_ENV=production
APP_KEY=your_app_key
DB_CONNECTION=mysql
DB_HOST=your_db_host
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
REDIS_HOST=your_redis_host
```

## Security Best Practices

✅ **Implemented:**
- Non-root container user
- Vulnerability scanning (Trivy)
- Secrets management (AWS Secrets Manager)
- Image scanning on push
- Least privilege IAM roles

✅ **Recommended:**
- Enable ECR image scanning
- Use AWS Systems Manager for secrets
- Implement container signing
- Set up AWS Config rules

## Rollback Strategy

### Quick Rollback

```bash
# List available image tags
aws ecr list-images --repository-name laravel-app-production

# Deploy previous version (example)
docker pull 123456789.dkr.ecr.us-east-1.amazonaws.com/laravel-app-production:v1.2.2
```

### Automated Rollback

The pipeline maintains the last 10 tagged versions automatically via ECR lifecycle policies.

## Cost Optimization

- **ECR**: Lifecycle policies remove old images
- **CodeBuild**: Uses appropriate instance sizes
- **S3**: Artifact retention policies
- **CloudWatch**: Log retention settings

## Customization

### Different Environments

```bash
# Deploy to staging
./scripts/deploy.sh staging us-east-1 YOUR_GITHUB_USERNAME YOUR_REPO_NAME develop

# Deploy to development
./scripts/deploy.sh development us-east-1 YOUR_GITHUB_USERNAME YOUR_REPO_NAME develop
```

### Custom Build Commands

Edit the `buildspec.yml` section in `cloudformation/codebuild-pipeline.yaml` to customize the build process.

### Additional Services

Extend the CloudFormation templates to add:
- Application Load Balancer
- ECS/Fargate service
- RDS database
- ElastiCache Redis
- CloudFront distribution

## Troubleshooting Common Issues

### Pipeline Fails at Source Stage
- Check GitHub token permissions
- Verify repository access
- Ensure webhook is configured

### Build Fails
- Check CodeBuild logs
- Verify Dockerfile syntax
- Ensure all dependencies are available

### ECR Push Fails
- Verify ECR repository exists
- Check IAM permissions
- Ensure ECR login is successful

### Container Health Checks Fail
- Verify `/health` endpoint works
- Check application startup time
- Review container logs

## Support

For issues or questions:
1. Check AWS CloudFormation events
2. Review CodeBuild logs
3. Verify GitHub Actions workflow logs
4. Check ECR repository policies