FROM node:18 AS build

WORKDIR /app

COPY package.json package-lock.json ./

RUN npm install

RUN npm install -g @angular/cli

COPY . .

RUN npm install

EXPOSE 4200

CMD ["npm", "start"]
