import { Stream } from './Stream';
import { injectable } from 'inversify';

@injectable()
export class Streams {

    static make(): Stream {return; }

    static merge() {}

    static has(): boolean {return false;}

    static build() {}

    static load() {}

    static register() {}

    static overload() {}

    static entries() {}

    static repository() {}

    static collection() {}

}
