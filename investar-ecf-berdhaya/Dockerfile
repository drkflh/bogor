FROM node:16 AS deps

WORKDIR /app
COPY package.json ./
RUN npm install

# Rebuild the source code only when needed
FROM node:16 AS builder
WORKDIR /app
COPY public ./public
COPY resources ./resources
COPY .babelrc webpack.mix.js ./
COPY --from=deps /app/package.json /app/package-lock.json ./
COPY --from=deps /app/node_modules ./node_modules
RUN npm run production

FROM 649498534151.dkr.ecr.ap-southeast-1.amazonaws.com/sapimoo-base:8.0

# Set workdir
WORKDIR /usr/share/nginx/html

COPY auth.json .
COPY composer.* ./
COPY database ./database

# run composer install to install the dependencies
RUN composer install \
  --optimize-autoloader \
  --no-interaction \
  --no-progress \
  --ignore-platform-reqs

COPY --from=builder /app/public ./public

# Supervisor config
COPY ./supervisord.conf /etc/supervisord.conf

# Override nginx's default config
COPY ./seeds/nginx.conf /etc/nginx/conf.d/default.conf

COPY --chown=nginx . .

EXPOSE 80

CMD ["./start.sh"]
