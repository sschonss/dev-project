# Etapa de construção
FROM node:22-alpine AS build

WORKDIR /frontend

# Copia os arquivos necessários para instalar dependências
COPY package.json package-lock.json ./

RUN npm ci

# Instala o Angular CLI globalmente
RUN npm install -g @angular/cli

# Copia os arquivos restantes e executa a build
COPY . .

RUN npm run build

# Etapa final: usa nginx para servir a aplicação
FROM nginx:alpine AS runtime

# Copia os arquivos compilados diretamente para o diretório padrão do Nginx
COPY --from=build /frontend/dist /usr/share/nginx/html

# Adiciona a configuração customizada para o Nginx
COPY nginx.conf /etc/nginx/conf.d/default.conf

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
