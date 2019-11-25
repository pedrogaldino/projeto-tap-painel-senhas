FROM node

RUN node -v
RUN npm install -g laravel-echo-server
RUN rm -rf /app/laravel-echo-server.lock

WORKDIR "/app"

CMD laravel-echo-server start --force
