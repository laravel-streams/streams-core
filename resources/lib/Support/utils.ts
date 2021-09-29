import { IServiceProviderClass, ServiceProvider } from './ServiceProvider';

export const makeLog = (namespace:string) => require('debug')(namespace)

export const isServiceProviderClass = (value: any): value is IServiceProviderClass => !(value instanceof ServiceProvider);
