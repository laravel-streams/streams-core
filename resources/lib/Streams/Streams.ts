import { Stream } from './Stream';
import { Http } from '@/Streams/Http';
import { Config } from '../types/config';

import { injectable } from 'inversify';
import { inject } from '@/Foundation';

@injectable()
export class Streams {

    @inject('config') config: Config;
    @inject('streams.http') http: Http;

    /**
     * Return all streams.
     * 
     * @returns 
     */
    public async all(): Promise<Stream[]> {
        
        const data = await this.http.getStreams();

        return data.data.map(data => new Stream(data));
    }

    /**
     * Make a stream instance.
     * 
     * @param id 
     * @returns 
     */
    public async make<ID extends string>(id: ID): Promise<Stream<ID>> {

        const data = await this.http.getStream(id)

        return new Stream(data.data, data.meta, data.links);
    }

    public merge() { }

    public has(): boolean { return false; }

    public build() { }

    public load() { }

    public register() { }

    public overload() { }

    public entries() {

    }

    public repository() { }

    public collection() { }

}
