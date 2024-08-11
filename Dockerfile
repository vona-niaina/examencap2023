FROM php:latest
RUN mkdir -p /home/exempledocker
WORKDIR /home/exempledocker
COPY . .
EXPOSE 8000
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]