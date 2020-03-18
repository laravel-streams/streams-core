import 'reflect-metadata'
//export * from './utils';
export * from './app';
export * from './src/Application';
// export * from './Config';
// export * from './Dispatcher';
// export * from './PlatformServiceProvider';
// export * from './ServiceProvider';
// export * from './VuePlugin';

import {StreamsServiceProvider} from './src/StreamsServiceProvider';

window.StreamsServiceProvider = StreamsServiceProvider;

window.streams.app.register(StreamsServiceProvider);
