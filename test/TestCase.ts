import { bootstrap } from './_support/bootstrap';
import {app, HttpServiceProvider, StreamsServiceProvider } from '../resources/lib';
import { Http } from '@/Streams/Http';

export abstract class TestCase {
    static before() { bootstrap(); }

    protected async createApp() {
        await app
        .initialize({
            providers: [
                HttpServiceProvider,
                StreamsServiceProvider,
            ],
            config: {
                http: {
                    baseURL: 'http://streams-dev.local/api'
                }
            }
        })
        .then(app.boot.bind(app))
        .then(app.start.bind(app));

        return app;
    }

    protected async getHttp(){
        const app = await this.createApp()
        return app.get<Http>('streams.http');
    }
}
