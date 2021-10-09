import { EventEmitter2 } from 'eventemitter2';
import { decorate, injectable, unmanaged } from 'inversify';

decorate(injectable(), EventEmitter2);

@injectable()
export class Dispatcher extends EventEmitter2 {

    protected anyListeners: Array<(...args: any[]) => void> = [];

    /**
     * Create a new Dispatcher instance.
     * 
     * @param opts 
     */
    constructor(@unmanaged() opts?) {
        super({
            wildcard: true,
            delimiter: ':'
        });
    }

    /**
     * Emit an event by name.
     * 
     * @param eventName 
     * @param args 
     * @returns 
     */
    public emit(eventName: string | symbol, ...args): boolean {
        let result = super.emit(eventName, ...args);
        this.anyListeners.forEach(listener => listener(eventName, ...args));
        return result;
    }

    /**
     * Register an event listener.
     * 
     * @param listener 
     */
    public any(listener: (...args: any[]) => void) {
        this.anyListeners.push(listener);
    }
}
