import { Stream } from './Stream';
import { Criteria } from '@/Streams/Criteria';


export class Repository<ID extends string = string> {
    constructor(protected stream: Stream) {}

    all(): this {return this;}

    find(): this {return this;}

    findAll(): this {return this;}

    findBy(): this {return this;}

    findAllWhere(): this {return this;}

    create(): this {return this;}

    save(): this {return this;}

    delete(): this {return this;}

    truncate(): this {return this;}

    newInstance(): this {return this;}

    newCriteria(): Criteria<ID> {return new Criteria<ID>(this.stream);}

    newSelfAdapter(): this {return this;}

    newFileAdapter(): this {return this;}

    newFilebaseAdapter(): this {return this;}

    newDatabaseAdapter(): this {return this;}

    newEloquentAdapter(): this {return this;}
}
