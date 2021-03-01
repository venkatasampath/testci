export default class Widget {
    constructor(id, name, size, visible, type, dataValues, dataList, chartLabels, chartColors, chartType, datasetLabel, chartHelp, dataType, updatedDatetime, cardStyle, showDetailsButton=false) {
        this.id = id;
        this.name = name;
        this.size = size;
        this.visible = visible;
        this.type = type;
        this.dataValues = dataValues;
        this.dataList = dataList;
        this.chartLabels = chartLabels;
        this.chartColors = chartColors;
        this.chartType = chartType;
        this.datasetLabel = datasetLabel;
        this.chartHelp = chartHelp;
        this.dataType = dataType;
        this.updatedDatetime = updatedDatetime;
        this.cardStyle = cardStyle;
        this.showDetailsButton = showDetailsButton;
    }
}