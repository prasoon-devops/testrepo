# Use a minimal and secure base image
FROM nginx:1.19-alpine

# Metadata labels
LABEL maintainer="email@test.com" \
      version="1.0" \
      description="NGINX 1.19 Alpine image"

# Create non-root user and group
RUN addgroup -S nginx && adduser -S nginx -G nginx

# Remove default config and copy custom config
RUN rm /etc/nginx/conf.d/default.conf
COPY nginx.conf /etc/nginx/nginx.conf

# Make log and www dirs writeable for the new user
RUN mkdir -p /var/cache/nginx /var/run /var/log/nginx && \
    chown -R nginx:nginx /var/cache/nginx /var/run /var/log/nginx

# Switch to non-root user
USER nginx

# Expose port
EXPOSE 8080

# Health check (use 8080 since we’ll listen on that instead of 80)
HEALTHCHECK --interval=30s --timeout=5s --retries=3 \
  CMD wget --spider --quiet http://localhost:8080 || exit 1

# Run nginx as foreground process
CMD ["nginx", "-g", "daemon off;"]