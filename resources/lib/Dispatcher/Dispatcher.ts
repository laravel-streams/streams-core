import EventEmitter from 'events';
import { decorate, injectable } from 'inversify';

decorate(injectable(), EventEmitter);

@injectable()
export class Dispatcher extends EventEmitter {
    protected anyListeners:Array<(...args: any[]) => void> = [];

    public emit(eventName: string | symbol, ...args): boolean {
        let result = super.emit(eventName, ...args);
        this.anyListeners.forEach(listener => listener(eventName, ...args));
        return result;
    }

    public any(listener: (...args: any[]) => void){
        this.anyListeners.push(listener);
    }
}
