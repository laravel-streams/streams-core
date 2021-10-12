import { Stream } from './Stream';
import { Http } from '@/Streams/Http';
import { Config } from '../types/config';

import { injectable } from 'inversify';
import { inject } from '@/Foundation';
import { Criteria, Repository } from '@';

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

        const data = await this.http.getStream(id);

        return new Stream(data.data, data.meta, data.links);
    }

    /**
     * Return an entry criteria.
     * 
     * @param id 
     * @returns Criteria
     */
    public async entries<ID extends string>(id: ID): Promise<Criteria> {

        const stream = await this.make(id);

        return new Criteria(stream);
    }

    /**
     * Return an entry repository.
     * 
     * @param id 
     * @returns 
     */
    public async repository<ID extends string>(id: ID): Promise<Repository> {

        const stream = await this.make(id);

        return new Repository(stream);
    }

    /**
     * Return the Streams collection.
     */
    public collection() {
        // return this._collection
    }
}
