import { bootstrap } from './_support/bootstrap';
import { app, HttpServiceProvider } from '../resources/lib';
import { FS, getEnv, ProxyEnv } from './_support/utils';

export interface ConfigData {
    'hash': string;
    'static': boolean;
    'public': boolean;
    'protected': boolean;
    'private': boolean;
    'abstract': boolean;
    'final': boolean;
    'inherited': boolean;
    stuff?:ConfigData & {
        others?:Omit<ConfigData,'stuff'>
    }
}


export abstract class TestCase {
    env: ProxyEnv<any>;
    fs: FS;

    before() {
        this.env = getEnv();
        this.fs  = new FS();
        this.fs.delete('streams/clients.json');
    }

    static before() { bootstrap(); }

    protected async createApp() {
        await app
        .initialize({
            providers: [
                HttpServiceProvider,
            ],
            config   : {},
        })
        .then(app.boot.bind(app))
        .then(app.start.bind(app));

        return app;
    }

    getConfigData():ConfigData {
        return {
            'hash'     : '6157fc77301ecc4fb2df2962',
            'static'   : false,
            'public'   : false,
            'protected': true,
            'private'  : false,
            'abstract' : false,
            'final'    : true,
            'inherited': true,
            'stuff'    : {
                'hash'     : '6157fc7757818d1266d0dac2',
                'static'   : true,
                'public'   : false,
                'protected': false,
                'private'  : true,
                'abstract' : true,
                'final'    : true,
                'inherited': false,
                'others'   : {
                    'hash'     : '6157fc77b07cc4f5672803cf',
                    'static'   : false,
                    'public'   : true,
                    'protected': false,
                    'private'  : false,
                    'abstract' : false,
                    'final'    : false,
                    'inherited': false,
                },
            },
        };

    }

}
