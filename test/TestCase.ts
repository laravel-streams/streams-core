import { bootstrap } from './_support/bootstrap';
import { app, HttpServiceProvider, Streams, StreamsServiceProvider } from '../resources/lib';
import { Http } from '@/Streams/Http';
import { FS, getEnv, ProxyEnv } from './_support/utils';

export abstract class TestCase {
    env: ProxyEnv<any>;
    fs:FS
    before() {
        this.env = getEnv();
        this.fs = new FS()
        this.fs.delete('streams/clients.json');
    }

    static before() { bootstrap(); }

    protected async createApp() {
        await app
        .initialize({
            providers: [
                HttpServiceProvider,
                StreamsServiceProvider,
            ],
            config   : {
                http: {
                    baseURL: this.env.get('APP_URL', 'http://localhost') + '/' + this.env.get('STREAMS_API_PREFIX', 'api'),
                },
                streams: {
                    xdebug: true
                }
            },
        })
        .then(app.boot.bind(app))
        .then(app.start.bind(app));

        return app;
    }

    protected async getHttp():Promise<Http> {
        const app = await this.createApp();
        return app.get<Http>('streams.http');
    }

    protected async getStreams():Promise<Streams>{
        const app = await this.createApp();
        return app.get<Streams>('streams');
    }

    protected getStreamData(id:string){
        return {
            id,
            'name'  : id,
            'source': {
                'type': 'file',
            },
            'fields': {
                'id'      : 'number',
                'name'    : 'string',
                'email'   : 'email',
                'relative': {
                    'type'  : 'relationship',
                    'config': {
                        'related': 'clients',
                    },
                },
            },
            'ui'    : { 'table': { 'columns': [ 'id', 'email' ], 'buttons': { 'edit': { 'href': `cp/${id}/{entry.id}/edit` } } }, 'form': {} },
        }
    }
}
