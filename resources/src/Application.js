import Vue, {ComponentOptions} from 'vue';
import {Container,AsyncContainerModule} from 'inversify';
// import {Config, IConfig, IServiceProviderClass, loadConfigDefaults, ServiceProvider} from '@pyro/platform';
import {merge} from 'lodash';
import {Dispatcher} from './Dispatcher';
import {ServiceProvider} from './ServiceProvider';
import {Config} from './Config';

const log = require('debug')('flow-theme:Application');

const getConfigDefaults = () => ({
    prefix    : 'py',
    debug     : false,
    csrf      : null,
    delimiters: [ '\{\{', '}}' ]
})

export class Application extends Container {

    constructor() {
        super({
            autoBindInjectable : false,
            defaultScope       : 'Transient',
            skipBaseClassChecks: false
        });
        this.Root = Vue.extend({});
        this.loadedProviders = {};
        this.providers = [];
        this.booted = false;
        this.started = false;
        this.shuttingDown = false;
        this.startEnabled = true;

        this.instance('app', this);
        this.singleton('events', Dispatcher);
    }

    extendRoot(options) {
        this.Root = this.Root.extend(options);
        return this;
    }

    /** @return {Storage} */
    get storage() {
        return this.get('storage');
    }

    /** @return {Cookies} */
    get cookies() {
        return this.get('cookies');
    }

    /** @return {Dispatcher} */
    get events() {
        return this.get('events');
    }

    /** @return {Config} */
    get data() {
        return this.get('data');
    }

    async bootstrap(_options, ...mergeOptions) {
        let options = merge({
            providers: [],
            config   : {},
            data     : {}
        }, _options, ...mergeOptions);
        log('bootstrap', {options});
        this.events.emit('app:bootstrap', options); //this.hooks.bootstrap.call(options);

        this.instance('data', Config.proxied(options.data));
        this.addBindingGetter('data');

        await this.loadProviders(options.providers);
        this.configure(options.config);

        await this.registerProviders(this.providers);
        this.events.emit('app:bootstrapped', options);
        return this;
    }

    async loadProviders(Providers) {
        log('loadProviders', {Providers});
        this.events.emit('loadProviders', Providers);
        await Promise.all(Providers.map(async Provider => this.loadProvider(Provider)));
        this.events.emit('loadedProviders', this.providers);
        return this;
    }


    async loadProvider(Provider) {
        if ( Provider.name in this.loadedProviders ) {
            return this.loadedProviders[Provider.name];
        }
        log('loadProvider', {Provider});
        this.events.emit('app:provider:load', Provider);
        let provider = new Provider(this);
        if ( 'configure' in provider && Reflect.getMetadata('configure', provider) !== true ) {
            const defaults = getConfigDefaults();
            Reflect.defineMetadata('configure', true, provider);
            await provider.configure(defaults);
        }
        if ( 'providers' in provider && Reflect.getMetadata('providers', provider) !== true ) {
            Reflect.defineMetadata('providers', true, provider);
            await this.loadProviders(provider.providers);
        }
        this.loadedProviders[Provider.name] = provider;
        this.providers.push(provider);
        this.events.emit('app:provider:loaded', provider);
        return provider;
    }

    configure(config) {
        config = merge({}, getConfigDefaults, config);
        this.events.emit('app:configure', config);
        let instance = Config.proxied(config);
        this.instance('config', instance);
        this.events.emit('app:configured', instance);
        return this;
    }

    async registerProviders(providers = this.providers) {
        this.events.emit('app:registerProviders', providers);
        await Promise.all(this.providers.map(async Provider => this.register(Provider)));
        this.events.emit('app:registeredProviders', providers);
        return this;
    }

    register = async (Provider) => {
        log('register', {Provider});
        this.events.emit('app:provider:register', Provider);
        let provider = Provider;
        if ( Provider instanceof ServiceProvider === false ) {
            provider = await this.loadProvider(Provider);
        }
        if ( 'register' in provider && Reflect.getMetadata('register', provider) !== true ) {
            Reflect.defineMetadata('register', true, provider);
            await this.loadAsync(new AsyncContainerModule(() => provider.register()));
        }
        this.providers.push(provider);
        this.events.emit('app:provider:registered', provider);
        return this;
    };

    boot = async () => {
        if ( this.booted ) {
            return this;
        }
        log('boot');
        this.booted = true;
        this.events.emit('app:boot');
        for (const provider of this.providers) {
            if ( 'boot' in provider && Reflect.getMetadata('boot', provider) !== true ) {
                this.events.emit('app:provider:booting', provider);
                Reflect.defineMetadata('boot', true, provider);
                await provider.boot();
                this.events.emit('app:provider:booted', provider);
            }
        }
        this.events.emit('app:booted');
        return this;
    };


    start = async (elementOrSelector='#app') => {
        log('start',{elementOrSelector,data:this.data,Root:this.Root})
        this.events.emit('app:start', elementOrSelector, {})
        this.root = new this.Root({
            data: () => {
                return this.data
            }

        });
        this.root.$mount(elementOrSelector);
        this.events.emit('app:started')
        log('started', this.root)
    }
    //
    // public sta123rt = async (mountPoint: string | HTMLElement = null, options: ComponentOptions<Vue> = {}) => {
    //     if ( this.started ) {
    //         return;
    //     }
    //     if ( !this.startEnabled ) {
    //         log('startEnabled=false', 'Skipping start', this);
    //         return;
    //     }
    //     log('start', { mountPoint, options });
    //     this.started = true;
    //     this.hooks.start.call(Vue);
    //     this.root = new (this.Root.extend({
    //         delimiters: this.config.delimiters
    //         // template: '<div id="app"><slot></slot></div>',
    //         // render(h,ctx){     return h(this.$slots.default, this.$slots.default)
    //         // data() {return self.data.raw()            }
    //     }));
    //     this.root.$mount(mountPoint);
    //     await this.root.$nextTick()
    //     this.instance('root', this.root)
    //     this.hooks.started.call(this.root);
    //
    //     return this;
    // };


    error = async (error) => {
        log('error', { error });
        this.events.emit('app:error',error)
        throw error;
    };

    addBindingGetter(id, key = null) {
        key        = key || id;
        const self = this;
        Object.defineProperty(this, key, {
            get() {return self.get(id);}
        });
    }
    //region: ioc
    alias(abstract, alias, singleton = false) {
        let binding = this.bind(alias).toDynamicValue(ctx => ctx.container.get(abstract));
        if ( singleton ) {
            binding.inSingletonScope();
        }
        return this;
    }

    bindIf(id, override, cb) {
        if ( this.isBound(id) && !override ) return this;
        cb(this.isBound(id) ? this.rebind(id) : this.bind(id));
        return this;
    }

    dynamic(id, cb) {
        return this.bind(id).toDynamicValue(ctx => {
            let req = ctx.currentRequest;
            return cb(this);
        });
    }

    singleton(id, value, override = false) {
        return this.bindIf(id, override, b => b.to(value).inSingletonScope());
    }

    binding(id, value) {

        return this;
    }

    instance(id, value, override = false) {
        return this.bindIf(id, override, b => b.toConstantValue(value));
    }

    ctxfactory(id, factory) {
        this.bind(id).toFactory(ctx => factory(ctx));
        return this;
    }

    factory(id, factory) {
        this.bind(id).toFactory(ctx => factory);
        return this;
    }

    //endregion
}
