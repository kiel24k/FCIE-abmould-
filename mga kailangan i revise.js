const admin = [
    PROFILE[{ EDIT_PROFILE: "" }],
    DASHBOARD[
        ({ CALCULATION_ON_BAR_GRAPH: "DONE" },
        { CALCULATION_ON_LINE_GRAPH: "DONE" },
        { CALCULATION_ON_PIE_CHART: "DONE" })
    ],
    SCHEDULE_REQUEST[
        { PRINT_TABLE: "DONE" },
        { NUMBER_OF_PENDING_APPROVE_NOT_APPROVED_RELEASED: "DONE" }
    ],
    ITEM_LIST[
        ({ NEW_ITEM_CAN_ADD_ITEM_TYPE_DYNAMICALLY: "DONE" },
        { ITEM_LIST_WITH_MANY_CATEGORY: "DONE" })
    ],
];

const inventory_manager = [
    HEADER[{ LOGOUT_STATEMENT: "DONE" }],
    DASHBOARD[
        ({ FIXED_UI_FOR_GRAPH: "DONE" },
        { CALCULATION_ON_BAR_GRAPH: "DONE" },
        { CALCULATION_ON_LINE_GRAPH: "DONE" },
        { CALCULATION_ON_PIE_CHART: "DONE" })
    ],
    SCHEDULE_REQUEST[
        ({ PRINT_TABLE: "DONE" },
        { NUMBER_OF_PENDING_APPROVE_NOT_APPROVED_RELEASED: "DONE" })
    ],
    ITEM_LIST[
        ({ FIX_UI_TABLE: "DONE" }, { ITEM_LIST_WITH_MANY_CATEGORY: "DONE" })
    ],
];

const member = [
    ITEM_LIST[
        ({ FIX_UI: "DONE" },
        { FIX_LOGOUT_ON_SIDEBAR_AND_MOVE_TO_HEADER: "DONE" },
        { LOGOUT_STATEMENT_ON_HEADER: "DONE" },
        { ITEM_LIST_WITH_MANY_CATEGORY: "DONE" })
    ],
];

const tl = [
    Home[
        { FIX_UI: "DONE" },
        {CHANGE_CATEGORY_TO_TABLE_CATEGORY: ''}

    ],
    SCHEDULE_REQUEST[
        { NUMBER_OF_PENDING_APPROVE_NOT_APPROVED_RELEASED: "DONE" }
    ],

];
