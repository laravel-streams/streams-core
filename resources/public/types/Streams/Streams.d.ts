import { Stream } from './Stream';
import { Http } from './Http';
import { Config } from '@/types';
import { Criteria } from './Criteria';
import { Repository } from './Repository';
export declare class Streams {
    config: Config;
    http: Http;
    /**
     * Return all streams.
     *
     * @returns
     */
    all(): Promise<Stream[]>;
    /**
     * Make a stream instance.
     *
     * @param id
     * @returns
     */
    make<ID extends string>(id: ID): Promise<Stream<ID>>;
    /**
     * Return an entry criteria.
     *
     * @param id
     * @returns Criteria
     */
    entries<ID extends string>(id: ID): Promise<Criteria>;
    /**
     * Return an entry repository.
     *
     * @param id
     * @returns
     */
    repository<ID extends string>(id: ID): Promise<Repository>;
    /**
     * Return the Streams collection.
     */
    collection(): void;
}
