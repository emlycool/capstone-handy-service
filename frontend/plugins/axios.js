import https from 'https';
import { Message } from 'element-ui'


export default function ({ $axios, redirect, app, store }) {

    $axios.defaults.httpsAgent = new https.Agent({ rejectUnauthorized: false });
    
    $axios.setBaseURL(process.env.baseUrl)

    $axios.onRequest(config => {
        console.log('Making request to ' + config.url)
        const token = store.getters['auth/bearerToken']; // Get token from the getter

        if (token) {
            config.headers.common['Authorization'] = `Bearer ${token}`;
        }
        return config;

    })
  
    $axios.onError(error => {

      const code = parseInt(error.response && error.response.status)
      const originalRequest = error.config

      const errorHandler = {
          401 : () => {
            store.commit("auth/clearBearerToken")
            redirect({name: 'auth-login', query:{ redirect: app.router.history.current.fullPath}})
          },
        //   400 : () => {
        //     redirect('/400')
        //   },
          403 : () => {
            Message.error('You do not have permission to perform this action')
            redirect('/403')
          },
          422: () => {
            Message.error(error?.response?.data?.message ??'Unprocessable Entity')
          },
        //   419: () => {
        //     Message.error('token mismatch, please wait while your token is refreshed')
        //     console.log({originalRequest});
        //     console.log('check', !originalRequest._retry);
        //     if(!originalRequest._retry){
        //       originalRequest._retry = true;
        //       return $axios.get('/sanctum/csrf-cookie')
        //       .then((res) => {
                
        //           return $axios(originalRequest)
       
        //       });
        //     }
        //   },

          'default' : () => {
            
          }
      }
      if(errorHandler.hasOwnProperty(code)){
        errorHandler[code]();
      }else{
        errorHandler.default();
      }


      return Promise.reject(error)

    })
  }