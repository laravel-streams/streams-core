import { Stream } from './Stream';
import { injectable } from 'inversify';
import { inject } from '@/Foundation';
import { Config } from '../types/config';

@injectable()
export class Streams {
    @inject('config') config:Config

    public make(): Stream {
        this.config.streams;
        return new Stream();
    }

    public merge() {}

    public has(): boolean {return false;}

    public build() {}

    public load() {}

    public register() {}

    public overload() {}

    public entries() {}

    public repository() {}

    public collection() {}

}
