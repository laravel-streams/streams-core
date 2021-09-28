import { ServiceProvider } from '@/Support';
import Axios from 'axios';

export class HttpServiceProvider extends ServiceProvider {
    register() {
        const axios = Axios.create({
            ...this.app.config.http,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                ...this.app.config.http.headers || {},
            },
        });
        this.app.instance('http', axios)
            .addBindingGetter('http');
    }
}
