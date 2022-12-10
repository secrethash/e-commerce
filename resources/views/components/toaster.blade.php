@php
	$sticky = $sticky ?? 'false';
	$timeout = $timeout ?? 4000;
@endphp
<script type="text/javascript">
	// Auto Toasts
	sticky = {{$sticky}};
	setTimeout( () => {
				
				toastr["{{$type ?? 'success'}}"](
					"{!! $slot !!}",
					"{!! $heading ?? ucfirst($type).'!' !!}",
					{
						closeButton: {{$close ?? 'true'}},
						tapToDismiss: {{$tapToDismiss ?? 'false'}},
						rtl: {{$rtl ?? 'false'}},
						positionClass: "toast-{{$position ?? 'top-right'}}",
						progressBar: {{($sticky === 'true') ? 'false' : ($progressBar ?? 'true')}},
						timeOut: {{($sticky === 'true') ? 0 : $timeout}},
					}
				);
				
		}, 1000);
</script>
