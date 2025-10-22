# Stage 1: Build
FROM node:22 as build-stage
WORKDIR /app
COPY . .
RUN npm install
RUN npm run build

# Stage 2: Serve with NGINX
FROM nginx:stable-alpine
COPY --from=build-stage /app/dist /usr/share/nginx/html
EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]
