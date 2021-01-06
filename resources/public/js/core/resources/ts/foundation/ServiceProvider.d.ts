import { IServiceProvider } from './types';
import { Application }      from './Application';

export declare abstract class ServiceProvider implements IServiceProvider {
    readonly app: Application;

    constructor(app: Application);
}
