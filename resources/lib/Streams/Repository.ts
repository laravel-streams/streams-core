import { Stream } from './Stream';


export class Repository {
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

    newCriteria(): this {return this;}

    newSelfAdapter(): this {return this;}

    newFileAdapter(): this {return this;}

    newFilebaseAdapter(): this {return this;}

    newDatabaseAdapter(): this {return this;}

    newEloquentAdapter(): this {return this;}
}
