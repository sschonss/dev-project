FROM node:22-alpine AS build

WORKDIR /frontend

COPY package.json package-lock.json ./

RUN npm ci

RUN npm install -g @angular/cli

COPY . .

RUN npm run build

FROM nginx:alpine AS runtime

COPY --from=build /frontend/dist /usr/share/nginx/html

COPY nginx.conf /etc/nginx/conf.d/default.conf

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
