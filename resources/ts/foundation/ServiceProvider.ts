import { IServiceProvider } from './types';
import { Application }      from './Application';

export abstract class ServiceProvider implements IServiceProvider {
    constructor(public readonly app: Application) {
    }
}
