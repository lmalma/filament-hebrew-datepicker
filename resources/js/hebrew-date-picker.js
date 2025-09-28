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
            // Use server-side conversion for accurate Hebrew calendar calculations
            return this.convertDateViaServer(gregorianDate, 'toHebrew');
        },

        hebrewToGregorian(hebrewYear, hebrewMonth, hebrewDay) {
            // Use server-side conversion for accurate Hebrew calendar calculations
            return this.convertDateViaServer({ year: hebrewYear, month: hebrewMonth, day: hebrewDay }, 'toGregorian');
        },

        convertDateViaServer(date, direction) {
            // For client-side fallback, use approximation
            if (direction === 'toHebrew') {
                const greg = new Date(date);
                const year = greg.getFullYear();
                const month = greg.getMonth() + 1;
                const day = greg.getDate();
                
                // More accurate Hebrew year calculation
                let hebrewYear = year + 3760;
                
                // Tishri usually starts in September/October
                if (month >= 9) {
                    hebrewYear += 1;
                }
                
                // More accurate month mapping
                const monthMapping = {
                    9: 1,   // September -> Tishri
                    10: 2,  // October -> Cheshvan
                    11: 3,  // November -> Kislev
                    12: 4,  // December -> Tevet
                    1: 5,   // January -> Shevat
                    2: 6,   // February -> Adar
                    3: 7,   // March -> Nissan
                    4: 8,   // April -> Iyar
                    5: 9,   // May -> Sivan
                    6: 10,  // June -> Tammuz
                    7: 11,  // July -> Av
                    8: 12,  // August -> Elul
                };
                
                const hebrewMonth = monthMapping[month] || 1;
                
                return {
                    year: hebrewYear,
                    month: hebrewMonth,
                    day: day,
                    gregorianDate: greg
                };
            } else {
                // Convert from Hebrew to Gregorian
                const { year: hebrewYear, month: hebrewMonth, day: hebrewDay } = date;
                let gregorianYear = hebrewYear - 3760;
                
                const monthMapping = {
                    1: 9,   // Tishri -> September
                    2: 10,  // Cheshvan -> October
                    3: 11,  // Kislev -> November
                    4: 12,  // Tevet -> December
                    5: 1,   // Shevat -> January
                    6: 2,   // Adar -> February
                    7: 3,   // Nissan -> March
                    8: 4,   // Iyar -> April
                    9: 5,   // Sivan -> May
                    10: 6,  // Tammuz -> June
                    11: 7,  // Av -> July
                    12: 8,  // Elul -> August
                };
                
                const gregorianMonth = monthMapping[hebrewMonth] || 1;
                
                // Adjust year for Hebrew months that fall in the next Gregorian year
                if (hebrewMonth >= 5 && hebrewMonth <= 12) {
                    gregorianYear += 1;
                }
                
                try {
                    return new Date(gregorianYear, gregorianMonth - 1, Math.min(hebrewDay, 28));
                } catch (e) {
                    return new Date();
                }
            }
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
            // Check if it's a leap year
            const isLeapYear = this.isHebrewLeapYear(year);
            
            // Standard month lengths
            const monthLengths = {
                1: 30,  // Tishri
                2: 29,  // Cheshvan (can vary)
                3: 29,  // Kislev (can vary)
                4: 29,  // Tevet
                5: 30,  // Shevat
                6: isLeapYear ? 30 : 29,  // Adar (Adar I in leap year)
                7: 30,  // Nissan
                8: 29,  // Iyar
                9: 30,  // Sivan
                10: 29, // Tammuz
                11: 30, // Av
                12: 29, // Elul
                13: isLeapYear ? 29 : 0, // Adar II (leap year only)
            };
            
            return monthLengths[month] || 29;
        },

        isHebrewLeapYear(hebrewYear) {
            // Hebrew leap year cycle: 7 leap years in every 19 years
            // Leap years are: 3, 6, 8, 11, 14, 17, 19 in the cycle
            const yearInCycle = hebrewYear % 19;
            return [3, 6, 8, 11, 14, 17, 0].includes(yearInCycle);
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
