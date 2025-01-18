

require('dotenv').config();

export const environment = {
  production: '${process.env.PRODUCTION}',
  apiUrl: '${process.env.API_URL}',
};
