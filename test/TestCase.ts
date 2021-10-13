import { bootstrap } from './_support/bootstrap';
import { app, Application, CoreServiceProvider, Http, HttpServiceProvider, Stream, Streams, StreamsServiceProvider } from '@';
import { FS, getEnv, ProxyEnv } from './_support/utils';

declare module '@/Foundation/Application' {
    export interface Application {
        env: ProxyEnv<any>;
    }
}

export abstract class TestCase {
    get env(): ProxyEnv<any> {return app.env;}

    fs: FS;
    app: Application = app;

    async before() {
        this.fs = new FS();
    }

    static async before() {
        const {env} = bootstrap();
        await this.createApp(env);
    }

    protected static async createApp(env) {
        if(!app.isBound('env')) {
            app.instance('env', env).addBindingGetter('env');
        }
        if(app.isBooted()){
            return app;
        }
        await app
        .initialize({
            providers: [
                CoreServiceProvider
            ],
            config   : {
                http   : {
                    baseURL: app.env.get('APP_URL', 'http://localhost') + '/' + app.env.get('STREAMS_API_PREFIX', 'api'),
                },
                streams: {
                    xdebug: true,
                },
            },
        })
        .then(app.boot.bind(app))
        .then(app.start.bind(app));

        return app;
    }

    protected async getHttp(): Promise<Http> {
        return this.app.get<Http>('streams.http');
    }

    protected async getStreams(): Promise<Streams> {
        return this.app.get<Streams>('streams');
    }
    protected async getStream(id:string): Promise<Stream> {
        return await this.app.get<Streams>('streams').make(id);
    }

    protected getStreamData(id: string) {
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
                'age'     : 'number',
                'relative': {
                    'type'  : 'relationship',
                    'config': {
                        'related': 'clients',
                    },
                },
            },
            'ui'    : { 'table': { 'columns': [ 'id', 'email' ], 'buttons': { 'edit': { 'href': `cp/${id}/{entry.id}/edit` } } }, 'form': {} },
        };
    }
}
