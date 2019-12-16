import Vue from 'vue';
import {injectable} from 'inversify';

let v = new Vue;

@injectable()
export class Dispatcher {
    emit(event, ...args) {
        v.$emit(event, ...args);
        return this;
    }

    on(event, callback) {
        v.$on(event, callback);
        return this;
    }

    once(event, callback) {
        v.$once(event, callback);
        return this;
    }

    off(event, callback) {
        v.$off(event, callback);
        return this;
    }
}
