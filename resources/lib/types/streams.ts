export namespace Streams.Core.Field {
  export interface FieldType {
    name: string;
    description: string;
    rules: any;
    config: { [key: string]: any };
  }
}
export namespace Streams.Core.Stream {
  export interface Stream {
    handle: string;
    repository: any;
    rules: Array<any>;
    validators: Array<any>;
    fields: any | Array<any>;
  }
}
export namespace Streams.Ui.Button {
  export interface Button {
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
    attributes: { [key: string]: any };
    handle: string;
    async: boolean;
    component: any;
    options: { [key: string]: any };
    data: any;
    response: any;
    stream: Streams.Core.Stream.Stream;
  }
}
export namespace Streams.Ui.ControlPanel {
  export interface ControlPanel {
    handle: string;
    template: string;
    async: boolean;
    component: any;
    classes: Array<any>;
    attributes: { [key: string]: any };
    options: { [key: string]: any };
    data: any;
    response: any;
    stream: Streams.Core.Stream.Stream;
  }
}
export namespace Streams.Ui.Form {
  export interface Form {
    values: any;
    options: { [key: string]: any };
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
    attributes: { [key: string]: any };
    data: any;
    response: any;
    stream: Streams.Core.Stream.Stream;
  }
}
export namespace Streams.Ui.Form.Action {
  export interface Action {
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
    attributes: { [key: string]: any };
    handle: string;
    async: boolean;
    component: any;
    options: { [key: string]: any };
    data: any;
    response: any;
    stream: Streams.Core.Stream.Stream;
  }
}
export namespace Streams.Ui.Input {
  export interface Input {
    handle: string;
    template: string;
    async: boolean;
    component: any;
    classes: Array<any>;
    attributes: { [key: string]: any };
    options: { [key: string]: any };
    data: any;
    response: any;
    stream: Streams.Core.Stream.Stream;
  }
}
export namespace Streams.Ui.Support {
  export interface Component {
    handle: string;
    template: string;
    async: boolean;
    component: any;
    classes: Array<any>;
    attributes: { [key: string]: any };
    options: { [key: string]: any };
    data: any;
    response: any;
    stream: Streams.Core.Stream.Stream;
  }
}
export namespace Streams.Ui.Table {
  export interface Table {
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
    attributes: { [key: string]: any };
    options: { [key: string]: any };
    data: any;
    response: any;
    stream: Streams.Core.Stream.Stream;
  }
}
export namespace Streams.Ui.Table.Action {
  export interface Action {
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
    attributes: { [key: string]: any };
    handle: string;
    async: boolean;
    component: any;
    options: { [key: string]: any };
    data: any;
    response: any;
    stream: Streams.Core.Stream.Stream;
  }
}
export namespace Streams.Ui.Table.Column {
  export interface Column {
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
    attributes: { [key: string]: any };
    options: { [key: string]: any };
    data: any;
    response: any;
    stream: Streams.Core.Stream.Stream;
  }
}
export namespace Streams.Ui.Table.Filter {
  export interface Filter {
    active: boolean;
    exact: boolean;
    query: any;
    handle: string;
    template: string;
    async: boolean;
    component: any;
    classes: Array<any>;
    attributes: { [key: string]: any };
    options: { [key: string]: any };
    data: any;
    response: any;
    stream: Streams.Core.Stream.Stream;
  }
}
export namespace Streams.Ui.Table.Row {
  export interface Row {
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
    attributes: { [key: string]: any };
    options: { [key: string]: any };
    data: any;
    response: any;
    stream: Streams.Core.Stream.Stream;
  }
}
export namespace Streams.Ui.Table.View {
  export interface View {
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
    attributes: { [key: string]: any };
    options: { [key: string]: any };
    data: any;
    response: any;
    stream: Streams.Core.Stream.Stream;
  }
}
