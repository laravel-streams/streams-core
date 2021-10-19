import { ServiceProvider } from '../Support';
import Axios, { AxiosInstance } from 'axios';
import { ETagCache } from '../Http/ETagCache';
import { ETag } from '../Http/ETag';

export class HttpServiceProvider extends ServiceProvider {

    /**
     * Register the service.
     */
    register() {
        this.registerAxios();
    }

    boot() {
        this.bootETag();
    }

    protected registerAxios() {
        // merge config with app config
        const config = {
            ...this.app.config.http,
            params : {
                ...this.app.config.http?.params || {},
            },
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                ...this.app.config.http?.headers || {},
            },
        };

        let streams = this.app.config.streams;
        if ( streams?.cache?.enabled ) {

        }
        if ( streams?.xdebug ) {
            config.headers[ 'Cookie' ]        = 'XDEBUG_SESSION=start';
            config.params[ 'XDEBUG_SESSION' ] = 'PHPSTORM';
        }
        if ( streams?.authentication ) {
            const { type, basic, token } = streams.authentication;
            if ( type === 'basic' ) {
                config.auth = {
                    username: basic.username,
                    password: basic.password,
                };
            } else if ( type === 'token' ) {
                config.headers[ 'Authorization' ] = 'Bearer ' + token;
            }
        }
        // create instance to use throughout the application
        const axios = Axios.create(config);
        // bind it as 'http' in the container, add 'http' getter property on the Application instance for easy access
        this.app.instance('axios', Axios);
        this.app.instance('http', axios).addBindingGetter('http');

    }

    protected bootETag() {
        // Add ETag caching to our axios instance
        // The ETag instance will also be accessible under 'etag' property on the axios instance
        if ( this.app.config.http.etag.enabled ) {
            const axios = this.app.http;
            this.app.singleton('http.etag.cache', ETagCache);
            this.app.instance('http.etag', new ETag(axios));
            axios.etag.enableEtag();
        }

    }
}

declare module 'axios' {
    export interface AxiosInstance {
        etag: ETag;
    }
}

declare module '../Foundation/Application' {
    export interface Application {
        http: AxiosInstance;
    }
}
