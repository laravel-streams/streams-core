import { streams } from '@/types';
import { Stream } from '@/Streams/Stream';
import { injectable } from 'inversify';
import { inject } from '@/Foundation';
import { Http } from '@/Streams/Http';

@injectable()
export class Entry<ID extends string =string>  {
    @inject('streams.http') http:Http

    constructor(protected _stream:Stream<ID>, data:any = {}){
        Object.assign(this, data)
    }

    get stream():Stream<ID>{
        return this._stream;
    }

    save(){
    }

    validator(){

    }

}
