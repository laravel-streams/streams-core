import { bootstrap } from './_support/bootstrap';
import { app, Application, CoreServiceProvider,  HttpServiceProvider } from '../resources/lib';
import { FS, getEnv, ProxyEnv } from './_support/utils';

declare module '../resources/lib/Foundation/Application' {
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

}
