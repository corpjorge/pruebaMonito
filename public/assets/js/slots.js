window.requestAnimFrame = (function(){
    return window.requestAnimationFrame ||
        window.webkitRequestAnimationFrame ||
        window.mozRequestAnimationFrame ||
        window.oRequestAnimationFrame ||
        window.msRequestAnimationFrame ||
        function(callback){
            window.setTimeout(callback, 1000 / 60);
        };
})();


/**
 * Отображение счета
 * @param label - подпись
 * @param x
 * @param y
 * @param width
 * @param height
 * @param figures - количество знаков
 * @param value
 * @constructor
 */
var Display = function(label, x, y, width, height, figures, value) {
    this.x = x;
    this.y = y;
    this.figures = figures || 1;
    this.width = width;
    this.height = height;
    this.label = label.toUpperCase();
    this.value = value;
};

Display.prototype = {
    /**
     * Метод отрисовки
     * @param ctx
     * @param value
     */
    draw: function(ctx, value) {
        ctx.save();

        var borderWidth = 3,
            paddingWidth = 8,
            offsetWidth = 6,
            figureWidth = (this.width - borderWidth - paddingWidth*2 - offsetWidth*(this.figures-1))/this.figures,
            borderGradient = ctx.createLinearGradient(0, 0, 0, this.width);

        borderGradient.addColorStop(0, "#454545");
        borderGradient.addColorStop(1, "#686868");

        ctx.clearRect(this.x, this.y, this.width, this.height);

        // параметры подписи
        var fontSize = 10;
        ctx.fillStyle = '#606060';
        ctx.font = "bold " + fontSize + "px Tahoma, sans-serif";

        // позиция по центру
        var textSize = ctx.measureText(this.label),
            textX = this.x + (this.width/2) - (textSize.width / 2),
            labelHeight = fontSize + 8;

        // рисуем подпись
        ctx.fillText(this.label, textX, this.y);

        // рисуем циферки с фоном и рамками
        ctx.fillStyle = '#210808';
        ctx.strokeStyle = borderGradient;
        ctx.lineWidth = borderWidth;

        // рисуем рамку со скругленными углами
        this._drawRoundedRect(ctx, this.x + borderWidth/2, this.y + labelHeight - borderWidth/2, this.width - borderWidth, this.height - labelHeight - borderWidth, 2);

        this.value = '' + value;
        var j = this.value.length - 1;
        var currentSymbol;

        // начинаем с последней ячейки
        for (var i = this.figures - 1; i >= 0; i--) {
            currentSymbol = false;

            // подбираем текущий символ для отображения
            while (currentSymbol === false) {
                if (this.value[j] === undefined) {
                    break;
                }

                if (this._figures[this.value[j]] !== undefined) {
                    currentSymbol = this._figures[this.value[j]];
                }

                j--;
            }

            this._drawFigure(
                ctx,
                this.x + borderWidth/2 + paddingWidth + (figureWidth + offsetWidth)*i,
                this.y + labelHeight - borderWidth/2 + paddingWidth,
                figureWidth,
                this.height - labelHeight - borderWidth - paddingWidth*2,
                currentSymbol
            );
        }

        ctx.restore();
    },

    /**
     * Рисуем рамку со скругленными углами
     * @param ctx
     * @param x
     * @param y
     * @param width
     * @param height
     * @param radius
     * @private
     */
    _drawRoundedRect: function(ctx, x, y, width, height, radius) {
        radius = radius || 5;

        ctx.beginPath();
        ctx.moveTo(x + radius, y);
        ctx.lineTo(x + width - radius, y);
        ctx.quadraticCurveTo(x + width, y, x + width, y + radius);
        ctx.lineTo(x + width, y + height - radius);
        ctx.quadraticCurveTo(x + width, y + height, x + width - radius, y + height);
        ctx.lineTo(x + radius, y + height);
        ctx.quadraticCurveTo(x, y + height, x, y + height - radius);
        ctx.lineTo(x, y + radius);
        ctx.quadraticCurveTo(x, y, x + radius, y);
        ctx.closePath();
        ctx.stroke();
    },


    /**
     * Рисуем циферку
     * @param ctx
     * @param x
     * @param y
     * @param width
     * @param height
     * @param figure
     * @private
     */
    _drawFigure: function(ctx, x, y, width, height, figure) {
        var segmentParams,
            lineWidth = Math.floor( width / 4);

        // рисуем фон
        ctx.fillRect(x, y, width, height);

        // рисуем циферку
        if (figure !== false) {
            for (var i = 0, sl = figure.length; i < sl; i++) {
                if (this._segmentParams[figure[i]] !== undefined && Object.prototype.toString.call(this._segmentParams[figure[i]]) === "[object Function]") {
                    segmentParams = this._segmentParams[figure[i]].call(this, x, y, width, height, lineWidth);

                    this._drawSegment(ctx, segmentParams.x, segmentParams.y, segmentParams.width, segmentParams.height);
                }
            }
        }
    },


    /**
     * Рисуем кусок цифры
     * @param ctx
     * @param x
     * @param y
     * @param width
     * @param height
     * @private
     */
    _drawSegment: function(ctx, x, y, width, height) {
        ctx.save();

        var shortSide = height < width ? height : width,
            halfShortSide = shortSide/2;

        ctx.fillStyle = '#ff8484';

        // рисуем восьмиугольник
        // в зависимости от направления некоторые углы будут сливаться
        ctx.beginPath();
        ctx.moveTo(x + halfShortSide, y);
        ctx.lineTo(x + width - halfShortSide, y);
        ctx.lineTo(x + width, y + halfShortSide);
        ctx.lineTo(x + width, y + height - halfShortSide);
        ctx.lineTo(x + width - halfShortSide, y + height);
        ctx.lineTo(x + halfShortSide, y + height);
        ctx.lineTo(x, y + height - halfShortSide);
        ctx.lineTo(x, y + halfShortSide);
        ctx.fill();

        ctx.restore();
    },

    /**
     * Отступ между сегментами чтоб не сливались
     */
    _offset: 3,


    /**
     * По переданным координатам ячейки возвращает координаты отрисовки сегментов
     */
    _segmentParams: {
        'top': function(x, y, width, height, lineWidth) {
            return { x: x + this._offset, y: y, width: width - this._offset*2, height: lineWidth }
        },
        'topRight': function(x, y, width, height, lineWidth) {
            return { x: x + width - lineWidth, y: y + this._offset, width: lineWidth, height: height/2 - this._offset }
        },
        'center': function(x, y, width, height, lineWidth) {
            return { x: x + this._offset, y: y + height/2 - lineWidth/2, width: width - this._offset*2, height: lineWidth }
        },
        'bottomRight': function(x, y, width, height, lineWidth) {
            return { x: x + width - lineWidth, y: y + height/2, width: lineWidth, height: height/2 - this._offset }
        },
        'bottom': function(x, y, width, height, lineWidth) {
            return { x: x + this._offset, y: y + height - lineWidth, width: width - this._offset*2, height: lineWidth }
        },
        'bottomLeft': function(x, y, width, height, lineWidth) {
            return { x: x, y: y + height/2, width: lineWidth, height: height/2 - this._offset }
        },
        'topLeft': function(x, y, width, height, lineWidth) {
            return { x: x, y: y + this._offset, width: lineWidth, height: height/2 - this._offset }
        }
    },


    /**
     * Цифекри
     */
    _figures: {
        '0': [ 'top', 'topRight', 'bottomRight', 'bottom', 'bottomLeft', 'topLeft' ],
        '1': [ 'topRight', 'bottomRight' ],
        '2': [ 'top', 'topRight', 'center', 'bottomLeft', 'bottom' ],
        '3': [ 'top', 'topRight', 'center', 'bottomRight', 'bottom' ],
        '4': [ 'topLeft', 'topRight', 'center', 'bottomRight' ],
        '5': [ 'top', 'topLeft', 'center', 'bottomRight', 'bottom' ],
        '6': [ 'top', 'topLeft', 'center', 'bottomRight', 'bottom', 'bottomLeft' ],
        '7': [ 'top', 'topRight', 'bottomRight' ],
        '8': [ 'top', 'topRight', 'center', 'bottomRight', 'bottom', 'bottomLeft', 'topLeft' ],
        '9': [ 'top', 'topRight', 'center', 'bottomRight', 'bottom', 'topLeft' ]
    }
};


/**
 * Кнопочки
 * @param text - подпись
 * @param x
 * @param y
 * @param width
 * @param height
 * @constructor
 */
var Button = function(text, x, y, width, height) {
    this.x = x;
    this.y = y;
    this.width = width;
    this.height = height;
    this.hovered = false;
    this.text = text;
    this.handlers = [];
};

Button.prototype = {
    /**
     * Вхождение курсора в область кнопки
     * @param obj
     * @param mouse
     * @returns {boolean}
     */
    intersects: function(obj, mouse) {
        var xIntersect = mouse.x > obj.x && mouse.x < obj.x + obj.width;
        var yIntersect = mouse.y > obj.y && mouse.y < obj.y + obj.height;
        return xIntersect && yIntersect;
    },


    update: function(ctx) {
        this.hovered = this.intersects(this, ctx.mouse);
    },


    draw: function(ctx) {
        ctx.save();

        // определяем цвет фона
        ctx.fillStyle = this.hovered ? '#ccc' : '#fff';

        // рисуем фон
        this._drawRoundedRect(ctx, this.x, this.y, this.width, this.height, 4);
        ctx.fill();

        // задаем параметры текста
        var fontSize = 20;
        ctx.fillStyle = '#000';
        ctx.font = fontSize + "px sans-serif";

        // вычисляем позицию текста по центру
        var textSize = ctx.measureText(this.text),
            textX = this.x + (this.width/2) - (textSize.width / 2),
            textY = this.y + (this.height/2) - (fontSize/2);

        // рисуем текст кнопки
        ctx.fillText(this.text, textX, textY);

        ctx.restore();
    },


    /**
     * Метод вызова подписчика события
     * @param e
     * @param type
     */
    handle: function(e, type) {
        if (this.handlers && this.handlers.length) {
            for (var i = 0, hl = this.handlers.length; i < hl; i++) {
                if (this.handlers[i].type === type && Object.prototype.toString.call(this.handlers[i].handler) === "[object Function]") {
                    this.handlers[i].handler.call(this, e);
                }
            }
        }
    },

    /**
     * Простенькая реализация подписки на события
     * @param type
     * @param handler
     * @returns {Button}
     */
    on: function(type, handler) {
        this.handlers.push({
            type: type,
            handler: handler
        });

        return this;
    },


    /**
     * Рисуем прямоугольник со скругленными углами
     * @param ctx
     * @param x
     * @param y
     * @param width
     * @param height
     * @param radius
     * @private
     */
    _drawRoundedRect: function(ctx, x, y, width, height, radius) {
        radius = radius || 5;

        ctx.beginPath();
        ctx.moveTo(x + radius, y);
        ctx.lineTo(x + width - radius, y);
        ctx.quadraticCurveTo(x + width, y, x + width, y + radius);
        ctx.lineTo(x + width, y + height - radius);
        ctx.quadraticCurveTo(x + width, y + height, x + width - radius, y + height);
        ctx.lineTo(x + radius, y + height);
        ctx.quadraticCurveTo(x, y + height, x, y + height - radius);
        ctx.lineTo(x, y + radius);
        ctx.quadraticCurveTo(x, y, x + radius, y);
        ctx.closePath();
    }
};


var Slot = function(options, canvasNode) {
    var i, j;

    // enums
    this.states = {
        REST: 0,
        BET: 1,
        SPINUP: 2,
        SPINDOWN: 3,
        REWARD: 4
    };

    var defaultOptions = {
        icons: [
            // порядок в массиве должен совпадать с порядком на изображении
            {
                id: '7',
                name: 'Семерка',
                count: 1    // количество на барабане
            },
            {
                id: 'C',
                name: 'Вишенка',
                count: 1
            },
            {
                id: '3',
                name: 'Три золотых слитка',
                count: 1
            },
            {
                id: '1',
                name: 'Золотой слиток',
                count: 3
            },
            {
                id: '2',
                name: 'Пара золотых слитков',
                count: 2
            }
        ],
        rulesScoring: [
            function(line, bet) {
                var score = [2, 4, 6][bet-1];
                // За каждую вишенку по n
                return +(line[0].id === 'C' && score)+(line[1].id === 'C' && score)+(line[2].id === 'C' && score)
            },
            function(line, bet) {
                var score = [5, 10, 15][bet-1];
                // Серия из слитков произвольного значения
                return +(
                    (line[0].id === '1' || line[0].id === '2' || line[0].id === '3') &&
                    (line[1].id === '1' || line[1].id === '2' || line[1].id === '3') &&
                    (line[2].id === '1' || line[2].id === '2' || line[2].id === '3') &&
                    score
                )
            },
            function(line, bet) {
                var score = [25, 50, 75][bet-1];
                // 1, 1, 1
                return +(line[0].id === '1' && line[1].id === '1' && line[2].id === '1' && score)
            },
            function(line, bet) {
                var score = [50, 100, 150][bet-1];
                // 2, 2, 2
                return +(line[0].id === '2' && line[1].id === '2' && line[2].id === '2' && score)
            },
            function(line, bet) {
                var score = [100, 200, 300][bet-1];
                // 3, 3, 3
                return +(line[0].id === '3' && line[1].id === '3' && line[2].id === '3' && score)
            },
            function(line, bet) {
                var score = [300, 600, 1500][bet-1];
                // 7, 7, 7
                return +(line[0].id === '7' && line[1].id === '7' && line[2].id === '7' && score)
            }
        ],
        iconsUrl: "assets/img/concurso/icons.png",
        reelBgUrl: "assets/img/concurso/reel.png",
        soundWinUrl: "sounds/win.wav",
        soundReelStopUrl: "sounds/reel_stop.wav",
        reelCount: 3,           // количество барабанов
        reelBorderWidth: 6,
        reelOffset: 30,         // расстояния между барабанами
        symbolSize: 130,        // размер тайла иконки
        maxReelSpeed: 65,       // максимальная скорость раскрутки барабанов
        minStopDelay: 300,      // минимальная задержка остановки барабана, мс
        maxStopDelay: 800,      // максимальная задержка остановки барабана, мс
        spinUpAcceleration: 5,  // скорость раскрутки барабанов
        spinDownAcceleration: 1,// скорость остановки барабанов
        startingCredits: 100,   // начальная сумма на счету
        animateFiguresDelay: 3,         // сколько кадров пропускать во время анимации начисления очков
        animateFiguresDelayGrand: 1,    // сколько кадров пропускать во время анимации начисления большого количества очков
        rewardGrand: 25,        // какую награду считать большой и увеличивать скорость начисления
        animateWinDelay: 10,    // сколько кадров пропускать во время анимации победы
        animateWinReelLightOffCount: 3, // сколько раз мигать во время анимации победы
        reelAreaLeft: 32,
        reelAreaTop: 32,
        reelAreaHeight: 190,
        displays: {
            pays: new Display("Pagado", 32, 250, 112, 68, 4),
            credits: new Display("Créditos", 165, 250, 112, 68, 4),
            bet: new Display("Apuesta", 310, 250, 36, 68, 1)
        }
    };

    // присваиваем значения "По умолчанию"
    for (var option in defaultOptions) {
        if (defaultOptions.hasOwnProperty(option)) {
            this[option] =  options[option] !== undefined ? options[option] : defaultOptions[option];
        }
    }

    this.ctx = canvasNode.getContext("2d");     // context
    this.ctx.textBaseline = "top";
    this.ctx.mouse = {
        x: 0,
        y: 0,
        clicked: false,
        down: false
    };

    canvasNode.addEventListener("mousemove", this.onMouseMove.bind(this));
    canvasNode.addEventListener("click", this.onClick.bind(this));

    canvasNode.addEventListener("touchend", (function(e) {
        if (e.touches[0]) {
            this.ctx.mouse.x = e.touches[0].pageX - canvasNode.offsetLeft;
            this.ctx.mouse.y = e.touches[0].pageY - canvasNode.offsetTop;

            this.onClick.call(this, e);
        }
    }).bind(this));

    // список кнопок
    this.buttons = [];

    // формируем шаблон для барабана
    var reelTemplate = [];
    for (i = 0; i < this.icons.length; i++) {
        for (j = 0; j < this.icons[i].count; j++) {
            reelTemplate.push(i);
        }
    }

    this.offsetToLine = Math.floor(this.reelAreaHeight / 2) - this.symbolSize;

    // количество иконок на барабане
    this.reelPositions = reelTemplate.length;

    this.reels = [];
    this.reelPosition = [];
    this.reelSpeed = [];
    this.result = [];

    for (i = 0; i < this.reelCount; i++) {
        // перемешиваем элементы шаблона для генерации барабанов
        this.reels[i] = [];
        for (j = 0; j < this.reelPositions; j++) {
            this.reels[i].splice(Math.floor(Math.random() * j), 0, reelTemplate[j]);
        }

        // задаем разное начальное расположение барабанов
        this.reelPosition[i] = Math.floor(Math.random() * this.reelPositions) * this.symbolSize - this.offsetToLine;

        // выставляем стартовую скорость вращения барабанов
        this.reelSpeed[i] = 0;
    }

    // рассчитаем высоту сгенерированного барабана в пикселях
    this.reelPixelLength = this.reelPositions * this.symbolSize;

    // число иконок влезающих в кадр
    this.rowCount = Math.ceil(this.reelAreaHeight / this.symbolSize);
    this.startSlowing = [];

    this.gameState = this.states.REST;
    this.credits = this.startingCredits;
    this.payout = 0;
    this.bet = 1;
    this._animateFiguresDelayCounter = 0;
    this._animateWinDelayCounter = 0;
    this._animateWinReelLightOffCounter = 0;
    this._animateWinDelayToggler = false;

    this.displays.pays.draw(this.ctx, '');
    this.displays.credits.draw(this.ctx, this.credits);
    this.displays.bet.draw(this.ctx, this.bet);

    this.symbols = new Image();
    this.symbols.src = this.iconsUrl;

    this.reelBg = new Image();
    this.reelBg.src = this.reelBgUrl;

    this.soundWin = new Audio(this.soundWinUrl);
    this.soundReelStop = [];
    this.soundReelStop[0] = new Audio(this.soundReelStopUrl);
    this.soundReelStop[1] = new Audio(this.soundReelStopUrl);
    this.soundReelStop[2] = new Audio(this.soundReelStopUrl);

    window.addEventListener('keydown', this.handleKey.bind(this), true);

    var symbolsLoaded,    // флаг загрузки иконок
        reelBgLoaded;     // флаг загрузки фона

    this.symbols.onload = (function() {
        symbolsLoaded = true;
        if (symbolsLoaded && reelBgLoaded) {
            this.renderReel();
            this.renderLine();
            this.start();
        }
    }).bind(this);

    this.reelBg.onload = (function() {
        reelBgLoaded = true;
        if (symbolsLoaded && reelBgLoaded) {
            this.renderReel();
            this.renderLine();
            this.start();
        }
    }).bind(this);
};


Slot.prototype = {

    //---- Render Functions ---------------------------------------------

    /**
     * Отрисовка иконки
     * @param symbolIndex
     * @param x
     * @param y
     * @param {Boolean} [moves=0] во время движения барабанов показываем размытые иконки
     */
    drawSymbol: function(symbolIndex, x, y, moves) {
        var symbol_pixel = symbolIndex * this.symbolSize;
        this.ctx.drawImage(this.symbols, moves ? this.symbolSize : 0, symbol_pixel, this.symbolSize, this.symbolSize, x + this.reelAreaLeft, y + this.reelAreaTop, this.symbolSize, this.symbolSize);
    },


    /**
     * Перерисовка барабанов
     */
    renderReel: function() {
        var reelIndex,
            symbolOffset,
            symbolIndex,
            x, y;

        for (var i = 0; i < this.reelCount; i++) {
            // сохраняем состояние
            this.ctx.save();

            // задаем цвет фона
            this.ctx.fillStyle = '#fff';

            // рисуем фон
            this.ctx.fillRect(this.reelAreaLeft + this.reelBorderWidth*(i+1) + (this.symbolSize + this.reelBorderWidth)*i + this.reelOffset*i, this.reelAreaTop + this.reelBorderWidth, this.symbolSize, this.reelAreaHeight);

            // ограничиваем область отрисовки
            this.ctx.beginPath();
            this.ctx.rect(this.reelAreaLeft + this.reelBorderWidth*(i+1) + (this.symbolSize + this.reelBorderWidth)*i + this.reelOffset*i, this.reelAreaTop + this.reelBorderWidth, this.symbolSize, this.reelAreaHeight);
            this.ctx.clip();

            for (var j = 0; j < this.rowCount + 1; j++) {
                reelIndex = Math.floor(this.reelPosition[i] / this.symbolSize) + j;
                symbolOffset = this.reelPosition[i] % this.symbolSize;

                if (reelIndex >= this.reelPositions) {
                    reelIndex -= this.reelPositions;
                }

                symbolIndex = this.reels[i][reelIndex];

                x = i * (this.symbolSize + this.reelBorderWidth) + this.reelOffset*i + this.reelBorderWidth*(i+1);
                y = j * this.symbolSize - symbolOffset;

                // рисуем иконку
                this.drawSymbol(symbolIndex, x, y, this.reelSpeed[i] > this.maxReelSpeed/4);
            }

            // сбрасываем состояние
            this.ctx.restore();

            // накладываем сверху картинку барабана
            this.ctx.drawImage(this.reelBg, this.reelAreaLeft + (this.symbolSize+this.reelBorderWidth*2)*i + this.reelOffset*i, this.reelAreaTop);
        }
    },


    /**
     * Перерисовка линии
     */
    renderLine: function() {
        this.ctx.save();

        // параметры линии
        this.ctx.fillStyle = '#a52325';
        this.ctx.strokeStyle = '#4d0000';
        this.ctx.lineWidth = 1;

        // обводка линии
        this.ctx.strokeRect(this.reelAreaLeft, this.reelAreaTop + Math.floor((this.reelAreaHeight + this.reelBorderWidth)/2) - 0.5, this.symbolSize*3 + this.reelOffset*3 + this.reelBorderWidth, 3);

        // рисуем левый треугольник
        this.ctx.beginPath();
        this.ctx.moveTo(this.reelAreaLeft - 2, this.reelAreaTop + Math.floor((this.reelAreaHeight + this.reelBorderWidth)/2) - 10);
        this.ctx.lineTo(this.reelAreaLeft + 10, this.reelAreaTop + Math.floor((this.reelAreaHeight + this.reelBorderWidth)/2) + 1);
        this.ctx.lineTo(this.reelAreaLeft - 2, this.reelAreaTop + Math.floor((this.reelAreaHeight + this.reelBorderWidth)/2) + 10);
        this.ctx.closePath();
        this.ctx.fill();
        this.ctx.stroke();

        // рисуем правый треугольник
        this.ctx.beginPath();
        this.ctx.moveTo(this.reelAreaLeft + this.symbolSize*3 + this.reelOffset*3 + this.reelBorderWidth + 2, this.reelAreaTop + Math.floor((this.reelAreaHeight + this.reelBorderWidth)/2) - 10);
        this.ctx.lineTo(this.reelAreaLeft + this.symbolSize*3 + this.reelOffset*3 + this.reelBorderWidth - 10, this.reelAreaTop + Math.floor((this.reelAreaHeight + this.reelBorderWidth)/2) + 1);
        this.ctx.lineTo(this.reelAreaLeft + this.symbolSize*3 + this.reelOffset*3 + this.reelBorderWidth + 2, this.reelAreaTop + Math.floor((this.reelAreaHeight + this.reelBorderWidth)/2) + 10);
        this.ctx.closePath();
        this.ctx.fill();
        this.ctx.stroke();

        // заливка линии
        this.ctx.fillRect(this.reelAreaLeft + 1, this.reelAreaTop + Math.floor((this.reelAreaHeight + this.reelBorderWidth)/2), this.symbolSize*3 + this.reelOffset*3 + 4, 2);

        this.ctx.restore();
    },


    /**
     * Перекрытие барабанов темным
     */
    renderReelLightOff: function() {
        // сохраняем состояние
        this.ctx.save();

        // задаем цвет фона
        this.ctx.fillStyle = 'rgba(0, 0, 0, 0.8)';

        for (var i = 0; i < this.reelCount; i++) {
            // перекрываем барабан
            this.ctx.fillRect(this.reelAreaLeft + this.reelBorderWidth*(i+1) + (this.symbolSize + this.reelBorderWidth)*i + this.reelOffset*i, this.reelAreaTop + this.reelBorderWidth, this.symbolSize, this.reelAreaHeight);
        }

        // сбрасываем состояние
        this.ctx.restore();
    },


    /**
     * Перерисовка
     */
    render: function() {
        if (this.buttons && this.buttons.length) {
            for (var i = 0, bl = this.buttons.length; i < bl; i++) {
                this.buttons[i].draw(this.ctx);
            }
        }

        switch (this.gameState) {
            case this.states.SPINUP:
            case this.states.SPINDOWN:
                this.renderReel();
                this.renderLine();
                break;
            case this.states.REWARD:
                if (this._animateWinReelLightOffCounter > 0) {
                    if (this._animateWinDelayCounter > 0) {
                        this._animateWinDelayCounter--;
                        return;
                    }

                    this.renderReel();

                    if (!this._animateWinDelayToggler) {
                        this.renderReelLightOff();
                    } else {
                        this._animateWinReelLightOffCounter--;
                    }

                    this.renderLine();

                    this._animateWinDelayToggler = !this._animateWinDelayToggler;
                    this._animateWinDelayCounter = this.animateWinDelay;
                }

                break;
        }
    },


    //---- Logic Functions ---------------------------------------------

    /**
     * Остановка барабанов по очереди через случайные промежутки времени
     * @param i
     */
    setStops: function(i) {
        i = i || 0;

        // начинаем
        window.setTimeout(
            (function(i) {
                this.startSlowing[i] = true;
                if (this.reels[++i]) {
                    this.setStops(i);
                }
            }).bind(this, i),
            Math.floor(Math.random() * (this.maxStopDelay - this.minStopDelay + 1)) + this.minStopDelay
        );
    },


    /**
     * Смещение барабана
     * @param i
     */
    moveReel: function(i) {
        this.reelPosition[i] -= this.reelSpeed[i];

        // повторяем
        if (this.reelPosition[i] < 0) {
            this.reelPosition[i] += this.reelPixelLength;
        }
    },


    /**
     * Логика установки ставок
     */
    logicBet: function() {
        // когда все очки начислены переключаем в режим ожидания
        if (this.displays.credits.value == this.credits && this.displays.bet.value == this.bet) {
            this.gameState = this.states.SPINUP;
            return;
        }

        // пропускаем кадры, чтоб не моргало слишком быстро
        if (this._animateFiguresDelayCounter > 0) {
            this._animateFiguresDelayCounter--;
            return;
        }

        if (this.displays.credits.value != this.credits) {
            this.displays.credits.draw(this.ctx, --this.displays.credits.value);
        }

        if (this.displays.bet.value != this.bet) {
            this.displays.bet.draw(this.ctx, this.displays.bet.value < this.bet ? ++this.displays.bet.value : --this.displays.bet.value);
        }

        this._animateFiguresDelayCounter = this.animateFiguresDelay;
    },


    /**
     * Логика набора скорости
     */
    logicSpinUp: function() {
        for (var i = 0; i < this.reelCount; i++) {
            // перемещаем барабан
            this.moveReel(i);

            // увеличиваем скорость
            this.reelSpeed[i] += this.spinUpAcceleration;
        }

        // как только достигли максимальной скорости начинаем остановку
        if (this.reelSpeed[0] == this.maxReelSpeed) {
            this.setStops();

            this.gameState = this.states.SPINDOWN;
        }
    },


    /**
     * Логика остановки барабанов
     */
    logicSpinDown: function() {
        // когда все барабаны остановлены
        if (this.reelSpeed[this.reelCount - 1] == 0) {
            this.calcReward();
            this.gameState = this.states.REWARD;
        }

        for (var i = 0; i < this.reelCount; i++) {
            if (this.reelSpeed[i] > 0) {
                // перемещаем барабан
                this.moveReel(i);

                /**
                 * не начинаем остановку пока не сработал таймер
                 * @see this.setStops
                 */
                if (this.startSlowing[i]) {
                    // когда скорость падает до минимума крутим барабан до фиксированного положения
                    if (this.reelSpeed[i] === this.spinDownAcceleration) {
                        var positionOffsetToLine = this.reelPosition[i] + this.offsetToLine;

                        if (positionOffsetToLine % Math.floor(this.symbolSize / 2)) {
                            continue;
                        } else {
                            // рассчитываем выпавшие ячейки
                            var stopIndex = positionOffsetToLine / Math.floor(this.symbolSize / 2) + 1;
                            this.result[i] = !(stopIndex % 2) && this.icons[this.reels[i][stopIndex / 2] !== undefined ? this.reels[i][stopIndex / 2] : this.reels[i][0]];

                            try {
                                // проигрываем музыку остановки барабана
                                this.soundReelStop[i].currentTime = 0;
                                this.soundReelStop[i].play();
                            } catch (err) {}
                        }
                    }

                    // уменьшаем скорость вращения
                    this.reelSpeed[i] -= this.spinDownAcceleration;
                }
            }
        }

    },


    /**
     * Логика показа результата
     */
    logicReward: function() {
        // когда все очки начислены переключаем в режим ожидания
        if (this.payout == 0) {
            if (this._animateWinReelLightOffCounter == 0) {
                this.gameState = this.states.REST;
            }

            return;
        }

        // пропускаем кадры, чтоб не моргало слишком быстро
        if (this._animateFiguresDelayCounter > 0) {
            this._animateFiguresDelayCounter--;
            return;
        }

        this.payout--;
        this.credits++;
        this.displays.credits.draw(this.ctx, this.credits);
        this.displays.pays.draw(this.ctx, ++this.displays.pays.value);

        if (this.payout < this.rewardGrand) {
            this._animateFiguresDelayCounter = this.animateFiguresDelay;
        }
        else { // большую сумму анимируем быстрее
            this._animateFiguresDelayCounter += this.animateFiguresDelayGrand;
        }

    },


    /**
     * Логика
     */
    logic: function() {
        if (this.buttons && this.buttons.length) {
            for (var i = 0, bl = this.buttons.length; i < bl; i++) {
                this.buttons[i].update(this.ctx);
            }
        }

        switch (this.gameState) {
            case this.states.BET:
                this.logicBet();
                break;
            case this.states.SPINUP:
                this.logicSpinUp();
                break;
            case this.states.SPINDOWN:
                this.logicSpinDown();
                break;
            case this.states.REWARD:
                this.logicReward();
                break;
        }
    },


    /**
     * Вычисление выигрыша
     */
    calcReward: function() {
        this.payout = 0;

        if (this.rulesScoring && this.rulesScoring.length) {
            for (var i = 0, rl = this.rulesScoring.length; i < rl; i++) {
                if (Object.prototype.toString.call(this.rulesScoring[i]) === "[object Function]") {
                    this.payout += this.rulesScoring[i](this.result, this.bet);
                }
            }
        }

        this.displays.pays.draw(this.ctx, 0);

        if (this.payout > 0) {
            this._animateWinReelLightOffCounter = this.animateWinReelLightOffCount;

            try {
                this.soundWin.currentTime = 0;
                this.soundWin.play();
            }
            catch (err) { }
        }
    },


    onMouseMove: function(e) {
        this.ctx.mouse.x = e.offsetX;
        this.ctx.mouse.y = e.offsetY;
    },


    onClick: function(e) {
        var i, bl;

        // передаем событие кнопочкам
        if (this.buttons && this.buttons.length) {
            for (i = 0, bl = this.buttons.length; i < bl; i++) {
                if (this.buttons[i].hovered) {
                    this.buttons[i].handle(e, "click");
                }
            }
        }
    },


    handleKey: function(e) {
        if (e.keyCode == 32) { // spacebar
            e.preventDefault();
            if (this.gameState != this.states.REST) return;

            this.betMax();
        }
    },


    /**
     * Запускаем барабаны
     * @param bet
     */
    spin: function(bet) {
        console.log(bet)
        this.bet = bet || this.bet;
        if (this.gameState != this.states.REST) return;
        if (this.credits < this.bet) return;

        this.credits -= this.bet;
        this.displays.pays.draw(this.ctx, '');

        this.startSlowing = [];
        this.result = [];
        this.gameState = this.states.BET;
    },


    /**
     * Ставим максимальную ставку и запускаем
     */
    betMax: function() {
        if (this.credits >= 3) this.spin(3);
        else if (this.credits == 2) this.spin(2);
        else if (this.credits == 1) this.spin(1);
    },


    /**
     * Прибавляем один к ставке если возможно
     */
    betOne: function() {
        if (this.gameState != this.states.REST) return;
        var newBet = this.bet + 1;

        if (newBet > this.credits || newBet > 3) {
            this.bet = 1;
        } else {
            this.bet++;
        }

        this.displays.bet.draw(this.ctx, this.bet);
    },


    start: function() {
        this.logic();
        this.render();
        requestAnimFrame( this.start.bind(this) );
    }
};


var slot = new Slot({}, document.getElementById("slots"));

slot.buttons.push(
    new Button("Uno", 32, 340, 100, 60).on('click', function(e) {
        slot.betOne();
    })
);

slot.buttons.push(
    new Button("Maximo", 155, 340, 100, 60).on('click', function(e) {
        slot.betMax();
    })
);

slot.buttons.push(
    new Button("Girar", 398, 320, 120, 80).on('click', function(e) {
        slot.spin();
    })
);

