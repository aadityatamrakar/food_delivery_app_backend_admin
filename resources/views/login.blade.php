@extends('partials.app')

@section('content')
    <div class="container">

        <div class="row" style="margin-top:20px">
            <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
                <form role="form" method="post" action="{{ route('login') }}">
                    <fieldset>
                        <h2>Please Sign In</h2>
                        <hr class="colorgraph">
                        <div class="form-group">
                            <input type="text" name="username" id="username" class="form-control input-lg" placeholder="Username">
                            {!! csrf_field() !!}
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" id="password" class="form-control input-lg" placeholder="Password">
                        </div>
                        <hr class="colorgraph">
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6 col-xs-offset-3">
                                <input type="submit" class="btn btn-lg btn-success btn-block" value="Log In">
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>

    </div>
@endsection


@section('script')
    <script>
        $(function(){
            $('.button-checkbox').each(function(){
                var $widget = $(this),
                        $button = $widget.find('button'),
                        $checkbox = $widget.find('input:checkbox'),
                        color = $button.data('color'),
                        settings = {
                            on: {
                                icon: 'glyphicon glyphicon-check'
                            },
                            off: {
                                icon: 'glyphicon glyphicon-unchecked'
                            }
                        };

                $button.on('click', function () {
                    $checkbox.prop('checked', !$checkbox.is(':checked'));
                    $checkbox.triggerHandler('change');
                    updateDisplay();
                });

                $checkbox.on('change', function () {
                    updateDisplay();
                });

                function updateDisplay() {
                    var isChecked = $checkbox.is(':checked');
                    // Set the button's state
                    $button.data('state', (isChecked) ? "on" : "off");

                    // Set the button's icon
                    $button.find('.state-icon')
                            .removeClass()
                            .addClass('state-icon ' + settings[$button.data('state')].icon);

                    // Update the button's color
                    if (isChecked) {
                        $button
                                .removeClass('btn-default')
                                .addClass('btn-' + color + ' active');
                    }
                    else
                    {
                        $button
                                .removeClass('btn-' + color + ' active')
                                .addClass('btn-default');
                    }
                }
                function init() {
                    updateDisplay();
                    // Inject the icon if applicable
                    if ($button.find('.state-icon').length == 0) {
                        $button.prepend('<i class="state-icon ' + settings[$button.data('state')].icon + '"></i> ');
                    }
                }
                init();
            });
        });
    </script>
@endsection