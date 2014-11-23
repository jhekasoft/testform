var Countdown = {
    startTimestamp: 0,
    countdownSeconds: 0,
    secondsLeft: 0,
    countdownStarted: false,
    changeCallback: null,
    timeout: null,
    savePersonalDataUrl: '',
    questionsUrl: '',
    start: function(startTimestamp, countdownSeconds, secondsLeft, changeCallback) {
        self.startTimestamp = startTimestamp;
        self.countdownSeconds = countdownSeconds;
        self.secondsLeft = secondsLeft;
        self.changeCallback = changeCallback;

        self.timeout = setInterval(function() {
            Countdown.change();
        }, 100);

        self.countdownStarted = true;
    },
    change: function() {
        date = new Date;
        var currentTimestamp = date.getTime()/1000;
        var timeHasPassed = currentTimestamp - self.startTimestamp;
        self.secondsLeft = self.countdownSeconds - timeHasPassed;
        if (self.secondsLeft < 0) {
            clearInterval(self.timeout);
            self.secondsLeft = 0;
            self.countdownStarted = false;
        }
        changeCallback(secondsLeft);
    },
    savePersonalData: function() {
        formData = $('.main-form-container form').serialize();

        //self.showAddSpinner();

        $.ajax({
            type: "POST",
            url: Countdown.savePersonalDataUrl,
            data: formData
        }).done(function(response) {
            if ('ok' == response.result && response.listHtml) {
                window.location = Countdown.questionsUrl;
            }

            if (response.addFormHtml) {
                $('.main-form-container').html(response.addFormHtml);
            }

            //Countdown.hideAddSpinner();
        });
    }
};


