import { Stream } from './Stream';
import { Config } from '@/types';
export declare class Streams {
    config: Config;
    make(): Stream;
    merge(): void;
    has(): boolean;
    build(): void;
    load(): void;
    register(): void;
    overload(): void;
    entries(): void;
    repository(): void;
    collection(): void;
}
