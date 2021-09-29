import { Stream } from './Stream';
import { injectable } from 'inversify';
import { inject } from '@/Foundation';
import { Config } from '../types/config';
import { streams } from '../types/streams';
import { Http } from '@/Streams/Http';

@injectable()
export class Streams {
    @inject('config') config: Config;
    @inject('streams.http') http: Http;

    public async all(): Promise<Stream[]> {
        const data = await this.http.getStreams()
        return data.data.map(data => new Stream(data))
    }

    public async make<ID extends string>(id: ID): Promise<Stream<ID>> {
        const data = await this.http.getStream(id)
        return new Stream(data.data);
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
