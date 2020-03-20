@foreach($userProjects as $project)
<div class="pp-item col-xs-12">
    <!-- <a class="delete" id="deleteFile" href="{{route('user.file.delete',$project->id)}}">
        <i class="fa fa-close "></i>
    </a> -->

    <div class="row border-bottom-gray">
        <div class="col-md-8">
            <a class="text-right boxshadow-unset d-flex"
                href="{{ asset(Storage::disk('public')->url($project->image)) }}" download>
                    <img class="w-auto"
                    src="{{ \App\AppConstants::getIconForFile(basename($project->image))}}" />
               <div class="past-projects-data mr-1">
                    <p>
                 {{   $filename = ($project->fileName != null) ? explode("." , $project->fileName)[0] : '' }}
                    </p>
                    <p style="direction: ltr;">
                    {{\App\AppConstants::formatSizeUnits($project->fileSize)}}
                    </p>
               </div>
            </a>
        </div>
        <div class="col-md-4  d-flex align-items-center justify-content-end">

                <!-- <div class="d-flex justify-content-center"> -->
                <a class="text-right boxshadow-unset h-auto download"
                    href="{{ asset(Storage::disk('public')->url($project->image)) }}" download>
                <i class="fa fa-download fa-lg"></i></a>
                <!-- <i class="fa fa-arrow-circle-down"></i> -->
                <a class="delete-front boxshadow-unset h-auto" id="deleteFile"
                    href="{{route('user.file.delete',$project->id)}}">

                    <i class="fa fa-trash fa-lg gray"></i>
                </a>
                <!-- </div> -->
        </div>
    </div>
</div>
@endforeach
