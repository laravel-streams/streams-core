import {EventEmitter2} from 'eventemitter2';
import { decorate, injectable,unmanaged } from 'inversify';

decorate(injectable(), EventEmitter2);

@injectable()
export class Dispatcher extends EventEmitter2 {
    protected anyListeners:Array<(...args: any[]) => void> = [];

    constructor(@unmanaged() opts?) {
        super({
            wildcard: true,
            delimiter:':'
        });
    }

    public emit(eventName: string | symbol, ...args): boolean {
        let result = super.emit(eventName, ...args);
        this.anyListeners.forEach(listener => listener(eventName, ...args));
        return result;
    }

    public any(listener: (...args: any[]) => void){
        this.anyListeners.push(listener);
    }
}
