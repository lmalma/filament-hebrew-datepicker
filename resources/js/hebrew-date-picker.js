export default function hebrewDatePickerFormComponent({
    locale = 'he',
    isAutofocused = false,
    shouldCloseOnDateSelection = true,
    state,
    firstDayOfWeek = 0,
    hasTime = false,
    hasSeconds = false,
}) {
    return {
        locale,
        firstDayOfWeek,
        hasTime,
        hasSeconds,
        shouldCloseOnDateSelection,
        
        displayText: '',
        focusedDate: null,
        focusedMonth: null,
        focusedYear: null,
        hour: 0,
        minute: 0,
        second: 0,
        
        hebrewMonths: [],
        dayLabels: [],
        
        emptyDaysInFocusedMonth: [],
        daysInFocusedMonth: [],

        init() {
            this.setupHebrewCalendar();
            this.initializeDate();
            
            if (isAutofocused) {
                this.focusOnField();
            }

            this.$watch('state', () => this.updateDisplayText());
            this.$watch('focusedMonth', () => this.calculateFocusedMonth());
            this.$watch('focusedYear', () => this.calculateFocusedMonth());
            this.$watch('hour', () => this.updateTimeState());
            this.$watch('minute', () => this.updateTimeState());
            this.$watch('second', () => this.updateTimeState());
        },

        setupHebrewCalendar() {
            if (this.locale === 'he') {
                this.hebrewMonths = [
                    'תשרי', 'חשון', 'כסלו', 'טבת', 'שבט', 'אדר',
                    'ניסן', 'אייר', 'סיון', 'תמוז', 'אב', 'אלול'
                ];
                this.dayLabels = ['א׳', 'ב׳', 'ג׳', 'ד׳', 'ה׳', 'ו׳', 'ש׳'];
            } else {
                this.hebrewMonths = [
                    'Tishri', 'Cheshvan', 'Kislev', 'Tevet', 'Shevat', 'Adar',
                    'Nissan', 'Iyar', 'Sivan', 'Tammuz', 'Av', 'Elul'
                ];
                this.dayLabels = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
            }
        },

        initializeDate() {
            const now = new Date();
            const hebrewDate = this.gregorianToHebrew(now);
            
            this.focusedMonth = hebrewDate.month;
            this.focusedYear = hebrewDate.year;
            this.focusedDate = hebrewDate;
            
            if (this.hasTime) {
                this.hour = now.getHours();
                this.minute = now.getMinutes();
                if (this.hasSeconds) {
                    this.second = now.getSeconds();
                }
            }

            this.updateDisplayText();
            this.calculateFocusedMonth();
        },

        gregorianToHebrew(gregorianDate) {
            // Simple Hebrew date conversion (this would need a proper library like heb-cal)
            // For now, this is a placeholder that converts roughly
            const greg = new Date(gregorianDate);
            const year = greg.getFullYear();
            const month = greg.getMonth() + 1;
            const day = greg.getDate();
            
            // Approximate Hebrew year calculation (3761 year difference + adjustments)
            const hebrewYear = year + 3761;
            
            // Simple month mapping (this is very approximate)
            let hebrewMonth = month + 6; // Rough offset
            if (hebrewMonth > 12) hebrewMonth -= 12;
            
            return {
                year: hebrewYear,
                month: hebrewMonth,
                day: day,
                gregorianDate: greg
            };
        },

        hebrewToGregorian(hebrewYear, hebrewMonth, hebrewDay) {
            // Simple conversion back to Gregorian (placeholder)
            const gregorianYear = hebrewYear - 3761;
            let gregorianMonth = hebrewMonth - 6;
            if (gregorianMonth <= 0) gregorianMonth += 12;
            
            return new Date(gregorianYear, gregorianMonth - 1, hebrewDay);
        },

        updateDisplayText() {
            if (!this.state) {
                this.displayText = '';
                return;
            }

            try {
                const date = new Date(this.state);
                const hebrewDate = this.gregorianToHebrew(date);
                
                if (this.locale === 'he') {
                    this.displayText = `${hebrewDate.day} ב${this.hebrewMonths[hebrewDate.month - 1]} ${hebrewDate.year}`;
                } else {
                    this.displayText = `${hebrewDate.day} ${this.hebrewMonths[hebrewDate.month - 1]} ${hebrewDate.year}`;
                }

                if (this.hasTime) {
                    const timeStr = this.hasSeconds 
                        ? `${date.getHours().toString().padStart(2, '0')}:${date.getMinutes().toString().padStart(2, '0')}:${date.getSeconds().toString().padStart(2, '0')}`
                        : `${date.getHours().toString().padStart(2, '0')}:${date.getMinutes().toString().padStart(2, '0')}`;
                    this.displayText += ` ${timeStr}`;
                }
            } catch (error) {
                this.displayText = '';
            }
        },

        calculateFocusedMonth() {
            if (!this.focusedYear || !this.focusedMonth) return;

            const daysInMonth = this.getHebrewMonthLength(this.focusedYear, this.focusedMonth);
            const firstDayOfMonth = this.getFirstDayOfHebrewMonth(this.focusedYear, this.focusedMonth);
            
            this.daysInFocusedMonth = Array.from({ length: daysInMonth }, (_, i) => i + 1);
            
            // Calculate empty days at the beginning
            let emptyDays = firstDayOfMonth - this.firstDayOfWeek;
            if (emptyDays < 0) emptyDays += 7;
            
            this.emptyDaysInFocusedMonth = Array.from({ length: emptyDays }, (_, i) => i);
        },

        getHebrewMonthLength(year, month) {
            // Simplified calculation - in reality, Hebrew months have varying lengths
            // and depend on whether it's a leap year, etc.
            const standardLengths = [30, 29, 29, 29, 30, 29, 30, 29, 30, 29, 30, 29];
            return standardLengths[month - 1] || 29;
        },

        getFirstDayOfHebrewMonth(year, month) {
            // Convert Hebrew date to Gregorian to get the day of week
            const gregorianDate = this.hebrewToGregorian(year, month, 1);
            return gregorianDate.getDay();
        },

        selectDate(day = null) {
            if (day) {
                this.focusedDate = {
                    year: this.focusedYear,
                    month: this.focusedMonth,
                    day: day
                };
            }

            if (!this.focusedDate) return;

            const gregorianDate = this.hebrewToGregorian(
                this.focusedDate.year,
                this.focusedDate.month,
                this.focusedDate.day
            );

            if (this.hasTime) {
                gregorianDate.setHours(this.hour, this.minute, this.hasSeconds ? this.second : 0, 0);
            }

            this.state = gregorianDate.toISOString();

            if (this.shouldCloseOnDateSelection && !this.hasTime) {
                this.closePicker();
            }
        },

        updateTimeState() {
            if (!this.hasTime || !this.focusedDate) return;
            
            const gregorianDate = this.hebrewToGregorian(
                this.focusedDate.year,
                this.focusedDate.month,
                this.focusedDate.day
            );

            gregorianDate.setHours(this.hour, this.minute, this.hasSeconds ? this.second : 0, 0);
            this.state = gregorianDate.toISOString();
        },

        clearState() {
            this.state = null;
            this.displayText = '';
        },

        dayIsToday(day) {
            const today = new Date();
            const todayHebrew = this.gregorianToHebrew(today);
            
            return todayHebrew.year === this.focusedYear &&
                   todayHebrew.month === this.focusedMonth &&
                   todayHebrew.day === day;
        },

        dayIsSelected(day) {
            if (!this.state) return false;
            
            try {
                const selectedDate = new Date(this.state);
                const selectedHebrew = this.gregorianToHebrew(selectedDate);
                
                return selectedHebrew.year === this.focusedYear &&
                       selectedHebrew.month === this.focusedMonth &&
                       selectedHebrew.day === day;
            } catch (error) {
                return false;
            }
        },

        dayIsDisabled(day) {
            const gregorianDate = this.hebrewToGregorian(this.focusedYear, this.focusedMonth, day);
            
            // Check against min/max dates
            const minDate = this.$refs.minDate?.value;
            const maxDate = this.$refs.maxDate?.value;
            
            if (minDate && gregorianDate < new Date(minDate)) return true;
            if (maxDate && gregorianDate > new Date(maxDate)) return true;
            
            // Check against disabled dates
            const disabledDates = JSON.parse(this.$refs.disabledDates?.value || '[]');
            const dateStr = gregorianDate.toISOString().split('T')[0];
            
            return disabledDates.includes(dateStr);
        },

        setFocusedDay(day) {
            this.focusedDate = {
                year: this.focusedYear,
                month: this.focusedMonth,
                day: day
            };
        },

        focusPreviousDay() {
            if (!this.focusedDate) return;
            
            let newDay = this.focusedDate.day - 1;
            let newMonth = this.focusedMonth;
            let newYear = this.focusedYear;
            
            if (newDay < 1) {
                newMonth--;
                if (newMonth < 1) {
                    newMonth = 12;
                    newYear--;
                }
                newDay = this.getHebrewMonthLength(newYear, newMonth);
            }
            
            this.focusedYear = newYear;
            this.focusedMonth = newMonth;
            this.setFocusedDay(newDay);
        },

        focusNextDay() {
            if (!this.focusedDate) return;
            
            let newDay = this.focusedDate.day + 1;
            let newMonth = this.focusedMonth;
            let newYear = this.focusedYear;
            
            const daysInMonth = this.getHebrewMonthLength(newYear, newMonth);
            
            if (newDay > daysInMonth) {
                newMonth++;
                if (newMonth > 12) {
                    newMonth = 1;
                    newYear++;
                }
                newDay = 1;
            }
            
            this.focusedYear = newYear;
            this.focusedMonth = newMonth;
            this.setFocusedDay(newDay);
        },

        focusPreviousWeek() {
            if (!this.focusedDate) return;
            
            for (let i = 0; i < 7; i++) {
                this.focusPreviousDay();
            }
        },

        focusNextWeek() {
            if (!this.focusedDate) return;
            
            for (let i = 0; i < 7; i++) {
                this.focusNextDay();
            }
        },

        isOpen() {
            return this.$refs.panel.style.display !== 'none' && 
                   !this.$refs.panel.hasAttribute('hidden');
        },

        togglePanelVisibility() {
            if (this.isOpen()) {
                this.closePicker();
            } else {
                this.openPicker();
            }
        },

        openPicker() {
            this.$refs.panel.style.display = 'block';
            this.$refs.panel.removeAttribute('hidden');
        },

        closePicker() {
            this.$refs.panel.style.display = 'none';
            this.$refs.panel.setAttribute('hidden', '');
        },

        focusOnField() {
            this.$nextTick(() => {
                this.$refs.button?.focus();
            });
        }
    };
}
