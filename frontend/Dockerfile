FROM node:23.8-alpine3.20

WORKDIR /app

COPY package*.json ./

RUN npm ci

COPY . .

EXPOSE 4200

CMD ["npm", "start", "--", "--host", "0.0.0.0"]
