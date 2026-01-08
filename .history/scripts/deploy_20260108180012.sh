#!/bin/bash

# Deployment script for Laravel application
set -e

# Configuration
STACK_NAME_PREFIX="laravel-app"
ENVIRONMENT=${1:-production}
AWS_REGION=${2:-us-east-1}
GITHUB_OWNER=${3}
GITHUB_REPO=${4}
GITHUB_BRANCH=${5:-main}

# Validate required parameters
if [ -z "$GITHUB_OWNER" ] || [ -z "$GITHUB_REPO" ]; then
    echo "Usage: $0 [environment] [aws-region] <github-owner> <github-repo> [github-branch]"
    echo "Example: $0 production us-east-1 mycompany myrepo main"
    exit 1
fi

echo "🚀 Deploying Laravel application infrastructure..."
echo "Environment: $ENVIRONMENT"
echo "Region: $AWS_REGION"
echo "GitHub: $GITHUB_OWNER/$GITHUB_REPO ($GITHUB_BRANCH)"

# Check if AWS CLI is configured
if ! aws sts get-caller-identity > /dev/null 2>&1; then
    echo "❌ AWS CLI not configured. Please run 'aws configure' first."
    exit 1
fi

# Create GitHub token secret if it doesn't exist
echo "📝 Checking GitHub token secret..."
if ! aws secretsmanager describe-secret --secret-id github-token --region $AWS_REGION > /dev/null 2>&1; then
    echo "⚠️  GitHub token secret not found. Creating placeholder..."
    aws secretsmanager create-secret \
        --name github-token \
        --description "GitHub personal access token for CodePipeline" \
        --secret-string '{"token":"REPLACE_WITH_YOUR_GITHUB_TOKEN"}' \
        --region $AWS_REGION
    
    echo "🔑 Please update the GitHub token secret:"
    echo "aws secretsmanager update-secret --secret-id github-token --secret-string '{\"token\":\"YOUR_GITHUB_TOKEN\"}' --region $AWS_REGION"
    echo ""
    echo "GitHub token needs these permissions:"
    echo "- repo (Full control of private repositories)"
    echo "- admin:repo_hook (Full control of repository hooks)"
    echo ""
fi

# Deploy ECR repository
echo "📦 Deploying ECR repository..."
aws cloudformation deploy \
    --template-file cloudformation/ecr-repository.yaml \
    --stack-name "$STACK_NAME_PREFIX-$ENVIRONMENT-ecr" \
    --parameter-overrides \
        ApplicationName=$STACK_NAME_PREFIX \
        Environment=$ENVIRONMENT \
    --region $AWS_REGION \
    --no-fail-on-empty-changeset

# Get ECR repository URI
ECR_URI=$(aws cloudformation describe-stacks \
    --stack-name "$STACK_NAME_PREFIX-$ENVIRONMENT-ecr" \
    --region $AWS_REGION \
    --query 'Stacks[0].Outputs[?OutputKey==`ECRRepositoryURI`].OutputValue' \
    --output text)

echo "📦 ECR Repository: $ECR_URI"

# Deploy CodeBuild and CodePipeline
echo "🔨 Deploying CI/CD pipeline..."
aws cloudformation deploy \
    --template-file cloudformation/codebuild-pipeline.yaml \
    --stack-name "$STACK_NAME_PREFIX-$ENVIRONMENT-pipeline" \
    --parameter-overrides \
        ApplicationName=$STACK_NAME_PREFIX \
        Environment=$ENVIRONMENT \
        GitHubOwner=$GITHUB_OWNER \
        GitHubRepo=$GITHUB_REPO \
        GitHubBranch=$GITHUB_BRANCH \
        ECRRepositoryURI=$ECR_URI \
    --capabilities CAPABILITY_NAMED_IAM \
    --region $AWS_REGION \
    --no-fail-on-empty-changeset

# Get pipeline name
PIPELINE_NAME=$(aws cloudformation describe-stacks \
    --stack-name "$STACK_NAME_PREFIX-$ENVIRONMENT-pipeline" \
    --region $AWS_REGION \
    --query 'Stacks[0].Outputs[?OutputKey==`PipelineName`].OutputValue' \
    --output text)

echo "✅ Deployment completed successfully!"
echo ""
echo "📋 Summary:"
echo "- ECR Repository: $ECR_URI"
echo "- Pipeline: $PIPELINE_NAME"
echo ""
echo "🔗 Next steps:"
echo "1. Update GitHub token secret if needed"
echo "2. Push code to trigger the pipeline"
echo "3. Monitor the pipeline in AWS Console"
echo ""
echo "🔍 Useful commands:"
echo "# Check pipeline status"
echo "aws codepipeline get-pipeline-state --name $PIPELINE_NAME --region $AWS_REGION"
echo ""
echo "# View ECR images"
echo "aws ecr list-images --repository-name $STACK_NAME_PREFIX-$ENVIRONMENT --region $AWS_REGION"