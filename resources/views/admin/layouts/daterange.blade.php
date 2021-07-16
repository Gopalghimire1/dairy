
<div class="row">
    <div class="col-md-3 ">
        <label for="type">
            Report Duration
        </label>
        <select name="type" id="type" onchange="manageDisplay(this)" class="form-control show-tick ms ">
            <option value="-1"></option>
            <option value="0">Session</option>
            <option value="1">Daily</option>
            <option value="2">Weekly</option>
            <option value="3">Monthly</option>
            <option value="4">Yearly</option>
            <option value="5">Custom</option>
        </select>

    </div>
    <div class="col-md-3 ct ct-0 ct-2 ct-3 ct-4 d-none">
        <label for="date">Year</label>
        <select name="year" id="year" class="form-control show-tick ms  load-year">
        </select>
    </div>
    <div class="col-md-3 ct ct-0  ct-2 ct-3 d-none">
        <label for="date">Month</label>
        <select name="month" id="month" class="form-control show-tick ms  load-month">
        </select>
    </div>
    <div class="col-md-3 ct ct-2 d-none">
        <label for="week">Week</label>
        <select name="week" id="week" class="form-control show-tick ms  load-week">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select>
    </div>
    <div class="col-md-3 ct ct-0 d-none">
        <label for="date">Session</label>
        <select name="session" id="session" class="form-control show-tick ms  load-session">
            <option value="1">1</option>
            <option value="2">2</option>
        </select>
    </div>
    <div class="col-md-3 ct ct-1 ct-5 d-none">
        <label for="Date1">Date1</label>
        <input type="text" id="date1" class="form-control calender">
    </div>
    <div class="col-md-3 ct ct-5 d-none">
        <label for="Date1">Date2</label>
        <input type="text" id="date2" class="form-control calender">
    </div>
</div>