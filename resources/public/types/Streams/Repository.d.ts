import { Stream } from './Stream';
export declare class Repository {
    protected stream: Stream;
    constructor(stream: Stream);
    all(): this;
    find(): this;
    findAll(): this;
    findBy(): this;
    findAllWhere(): this;
    create(): this;
    save(): this;
    delete(): this;
    truncate(): this;
    newInstance(): this;
    newCriteria(): this;
    newSelfAdapter(): this;
    newFileAdapter(): this;
    newFilebaseAdapter(): this;
    newDatabaseAdapter(): this;
    newEloquentAdapter(): this;
}
