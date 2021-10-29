export declare namespace Streams.Core.Field {
    interface FieldType {
        name: string;
        description: string;
        rules: any;
        config: {
            [key: string]: any;
        };
    }
}
export declare namespace Streams.Core.Stream {
    interface Stream {
        handle: string;
        repository: any;
        rules: Array<any>;
        validators: Array<any>;
        fields: any | Array<any>;
    }
}
export declare namespace Streams.Ui.Button {
    interface Button {
        template: string;
        tag: string;
        url: string;
        text: any;
        entry: any;
        policy: any;
        enabled: boolean;
        primary: boolean;
        disabled: boolean;
        type: string;
        classes: Array<any>;
        attributes: {
            [key: string]: any;
        };
        handle: string;
        async: boolean;
        component: any;
        options: {
            [key: string]: any;
        };
        data: any;
        response: any;
        stream: Streams.Core.Stream.Stream;
    }
}
export declare namespace Streams.Ui.ControlPanel {
    interface ControlPanel {
        handle: string;
        template: string;
        async: boolean;
        component: any;
        classes: Array<any>;
        attributes: {
            [key: string]: any;
        };
        options: {
            [key: string]: any;
        };
        data: any;
        response: any;
        stream: Streams.Core.Stream.Stream;
    }
}
export declare namespace Streams.Ui.Form {
    interface Form {
        values: any;
        options: {
            [key: string]: any;
        };
        rules: any;
        validators: any;
        errors: Array<any>;
        sections: any;
        fields: any | Array<Streams.Core.Field.FieldType>;
        actions: any | Array<Streams.Ui.Form.Action.Action>;
        buttons: any | Array<Streams.Ui.Button.Button>;
        handle: string;
        template: string;
        async: boolean;
        component: any;
        classes: Array<any>;
        attributes: {
            [key: string]: any;
        };
        data: any;
        response: any;
        stream: Streams.Core.Stream.Stream;
    }
}
export declare namespace Streams.Ui.Form.Action {
    interface Action {
        action: boolean;
        template: string;
        tag: string;
        url: string;
        text: any;
        entry: any;
        policy: any;
        enabled: boolean;
        primary: boolean;
        disabled: boolean;
        type: string;
        classes: Array<any>;
        attributes: {
            [key: string]: any;
        };
        handle: string;
        async: boolean;
        component: any;
        options: {
            [key: string]: any;
        };
        data: any;
        response: any;
        stream: Streams.Core.Stream.Stream;
    }
}
export declare namespace Streams.Ui.Input {
    interface Input {
        handle: string;
        template: string;
        async: boolean;
        component: any;
        classes: Array<any>;
        attributes: {
            [key: string]: any;
        };
        options: {
            [key: string]: any;
        };
        data: any;
        response: any;
        stream: Streams.Core.Stream.Stream;
    }
}
export declare namespace Streams.Ui.Support {
    interface Component {
        handle: string;
        template: string;
        async: boolean;
        component: any;
        classes: Array<any>;
        attributes: {
            [key: string]: any;
        };
        options: {
            [key: string]: any;
        };
        data: any;
        response: any;
        stream: Streams.Core.Stream.Stream;
    }
}
export declare namespace Streams.Ui.Table {
    interface Table {
        rows: any | Array<Streams.Ui.Table.Row.Row>;
        views: any | Array<Streams.Ui.Table.View.View>;
        columns: any | Array<Streams.Ui.Table.Column.Column>;
        actions: any | Array<Streams.Ui.Table.Action.Action>;
        filters: any | Array<Streams.Ui.Table.Filter.Filter>;
        buttons: any | Array<Streams.Ui.Button.Button>;
        handle: string;
        template: string;
        async: boolean;
        component: any;
        classes: Array<any>;
        attributes: {
            [key: string]: any;
        };
        options: {
            [key: string]: any;
        };
        data: any;
        response: any;
        stream: Streams.Core.Stream.Stream;
    }
}
export declare namespace Streams.Ui.Table.Action {
    interface Action {
        action: boolean;
        template: string;
        tag: string;
        url: string;
        text: any;
        entry: any;
        policy: any;
        enabled: boolean;
        primary: boolean;
        disabled: boolean;
        type: string;
        classes: Array<any>;
        attributes: {
            [key: string]: any;
        };
        handle: string;
        async: boolean;
        component: any;
        options: {
            [key: string]: any;
        };
        data: any;
        response: any;
        stream: Streams.Core.Stream.Stream;
    }
}
export declare namespace Streams.Ui.Table.Column {
    interface Column {
        entry: any;
        view: string;
        direction: string;
        prefix: string;
        value: any;
        heading: any;
        wrapper: any;
        sortable: boolean;
        field: any;
        handle: string;
        template: string;
        async: boolean;
        component: any;
        classes: Array<any>;
        attributes: {
            [key: string]: any;
        };
        options: {
            [key: string]: any;
        };
        data: any;
        response: any;
        stream: Streams.Core.Stream.Stream;
    }
}
export declare namespace Streams.Ui.Table.Filter {
    interface Filter {
        active: boolean;
        exact: boolean;
        query: any;
        handle: string;
        template: string;
        async: boolean;
        component: any;
        classes: Array<any>;
        attributes: {
            [key: string]: any;
        };
        options: {
            [key: string]: any;
        };
        data: any;
        response: any;
        stream: Streams.Core.Stream.Stream;
    }
}
export declare namespace Streams.Ui.Table.Row {
    interface Row {
        columns: any | Array<Streams.Ui.Table.Column.Column>;
        buttons: any | Array<Streams.Ui.Button.Button>;
        key: string | number;
        entry: any;
        table: Streams.Ui.Table.Table;
        handle: string;
        template: string;
        async: boolean;
        component: any;
        classes: Array<any>;
        attributes: {
            [key: string]: any;
        };
        options: {
            [key: string]: any;
        };
        data: any;
        response: any;
        stream: Streams.Core.Stream.Stream;
    }
}
export declare namespace Streams.Ui.Table.View {
    interface View {
        text: string;
        icon: string;
        label: string;
        prefix: string;
        actions: any | Array<Streams.Ui.Table.View.View>;
        columns: Array<Streams.Ui.Table.Column.Column>;
        entries: Array<any>;
        filters: any | Array<Streams.Ui.Table.Filter.Filter>;
        buttons: any | Array<Streams.Ui.Button.Button>;
        handler: any;
        query: any;
        active: boolean;
        context: string;
        handle: string;
        template: string;
        async: boolean;
        component: any;
        classes: Array<any>;
        attributes: {
            [key: string]: any;
        };
        options: {
            [key: string]: any;
        };
        data: any;
        response: any;
        stream: Streams.Core.Stream.Stream;
    }
}
