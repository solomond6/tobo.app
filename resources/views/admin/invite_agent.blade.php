@extends('layouts.adminlayout')
@section('content')

<style type="text/css">
.tree, .tree ul {
    margin:0;
    padding:0;
    list-style:none
}
.tree ul {
    margin-left:1em;
    position:relative
}
.tree ul ul {
    margin-left:.5em
}
.tree ul:before {
    content:"";
    display:block;
    width:0;
    position:absolute;
    top:0;
    bottom:0;
    left:0;
    border-left:1px solid
}
.tree li {
    margin:0;
    padding:0 1em;
    line-height:2em;
    color:#369;
    font-weight:700;
    position:relative
}
.tree ul li:before {
    content:"";
    display:block;
    width:10px;
    height:0;
    border-top:1px solid;
    margin-top:-1px;
    position:absolute;
    top:1em;
    left:0
}
.tree ul li:last-child:before {
    background:#fff;
    height:auto;
    top:1em;
    bottom:0
}
.indicator {
    margin-right:5px;
}
.tree li a {
    text-decoration: none;
    color:#369;
    width: 100%;
}
.tree li button, .tree li button:active, .tree li button:focus {
    text-decoration: none;
    color:#369;
    border:none;
    background:transparent;
    margin:0px 0px 0px 0px;
    padding:0px 0px 0px 0px;
    outline: 0;
}
</style>
<div class="row">
  <div class="col-md-8">
    <div class="card mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-dark">Downlines</h6>
      </div>
      <div class="card-body">
        <!-- <ul id="tree1">
            <li><a href="#">TECH</a>
                <ul>
                    <li>Company Maintenance</li>
                    <li>Employees
                        <ul>
                            <li>Reports
                                <ul>
                                    <li>Report1</li>
                                    <li>Report2</li>
                                    <li>Report3</li>
                                </ul>
                            </li>
                            <li>Employee Maint.</li>
                        </ul>
                    </li>
                    <li>Human Resources</li>
                </ul>
            </li>
        </ul> -->
        <ul id="tree1">
            @foreach ($downlines as $ref)
                <li><a href="#" class="btn btn-outline-primary text-start mt-3">{{ $ref['username'] }}
                    @if(isset($ref['upline']))
                        --- Referred by {{$ref['upline']['username']}}
                    @endif
                    </a>
                    <ul>
                        @foreach ($ref['downline'] as $children)
                            <li>
                                <a class="btn btn-outline-primary text-start mt-1"> {{ $children['username'] }} </a>
                                <ul>
                                    @foreach ($children['downline'] as $grandchildren)
                                        <li>
                                            <a class="btn btn-outline-primary text-start mt-1"> {{ $grandchildren['username'] }} </a>
                                            <ul>
                                                @foreach ($grandchildren['downline'] as $sgrandchildren)                            
                                                    <li><a class="btn btn-outline-primary text-start mt-1">{{ $sgrandchildren['username'] }}</a></li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endforeach
        </ul>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-dark">Agent Invitation</h6>
      </div>
      <div class="card-body">
          @if(session('success'))
            <div class="alert alert-success">
              {{ session('success') }}
            </div>
          @endif
          @if(session('error'))
            <div class="alert alert-danger">
              {{ session('error') }}
            </div>
          @endif
          {!! Form::open(['url'=>'/admin/sendinvite', 'class'=>'form', 'enctype'=>'multipart/form-data']) !!}
            <div class="form-group has-feedback">
              {!! Form::label('Email') !!}
              {!! Form::text('agent_email', null, ['class'=>'form-control', 'required'=> 'required']) !!}
            </div>
            <div class="form-group">
              {!! Form::submit('Submit', ['class'=>'btn btn-primary btn-block btn-flat']) !!}
            </div>
          {!! Form::close() !!}
      </div>
    </div>
  </div>
</div>

<script>
    $.fn.extend({
    treed: function (o) {
      
      var openedClass = 'glyphicon-minus-sign';
      var closedClass = 'glyphicon-plus-sign';
      
      if (typeof o != 'undefined'){
        if (typeof o.openedClass != 'undefined'){
        openedClass = o.openedClass;
        }
        if (typeof o.closedClass != 'undefined'){
        closedClass = o.closedClass;
        }
      };
      
        //initialize each of the top levels
        var tree = $(this);
        tree.addClass("tree");
        tree.find('li').has("ul").each(function () {
            var branch = $(this); //li with children ul
            branch.prepend("<i class='indicator glyphicon " + closedClass + "'></i>");
            branch.addClass('branch');
            branch.on('click', function (e) {
                if (this == e.target) {
                    var icon = $(this).children('i:first');
                    icon.toggleClass(openedClass + " " + closedClass);
                    $(this).children().children().toggle();
                }
            })
            branch.children().children().toggle();
        });
        //fire event from the dynamically added icon
      tree.find('.branch .indicator').each(function(){
        $(this).on('click', function () {
            $(this).closest('li').click();
        });
      });
        //fire event to open branch if the li contains an anchor instead of text
        tree.find('.branch>a').each(function () {
            $(this).on('click', function (e) {
                $(this).closest('li').click();
                e.preventDefault();
            });
        });
        //fire event to open branch if the li contains a button instead of text
        tree.find('.branch>button').each(function () {
            $(this).on('click', function (e) {
                $(this).closest('li').click();
                e.preventDefault();
            });
        });
    }
});

//Initialization of treeviews

$('#tree1').treed();

$('#tree2').treed({openedClass:'glyphicon-folder-open', closedClass:'glyphicon-folder-close'});

$('#tree3').treed({openedClass:'glyphicon-chevron-right', closedClass:'glyphicon-chevron-down'});

</script>
@endsection