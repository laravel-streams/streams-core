import { AxiosAdapter } from 'axios';
import { ServiceProvider } from './foundation/ServiceProvider';

const axios = require('axios');

export class StreamsServiceProvider extends ServiceProvider {

    public register() {

        this.app.factory('http', () => {
            return axios;
        });
    }
}
