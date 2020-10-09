@extends('layouts.app')

@section('content')

<div class="container mt-2">
    <div class="card shadow-sm">
        <div class="card-body">
            <h3 class="card-title text-primary"> <v-icon color="primary">mdi-pencil-outline</v-icon> Create Board Agenda</h3>

            <form action="/board/agenda" method="post" enctype="multipart/form-data">
            @csrf
                <div class="row">
                    <div class="col-6">
                        <label for="category">Category</label>
                        <select name="category" id="category" class="form-control" v-model="boardAgenda.input.category">
                            @foreach ($categories as $category)
                                <option>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6">
                        <label for="type">Remarks</label>
                        <select name="type" id="type" class="form-control" v-model="boardAgenda.input.type">
                            <option :value="remark.name" v-for="remark in remarks"> @{{ remark.name }} </option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label for="uid">Agenda Item No</label>
                        <input type="text" class="form-control" name="uid" v-model="boardAgenda.output.calculatedUid" required>
                        <small class="text-danger" v-if="! boardAgenda.input.name">Update board meeting name for autocompletion</small>
                    </div>
                    <div class="col-6">
                        <label for="committee">Recommended Through</label>
                        <select name="committee_id" id="committee_id" class="form-control">
                            @foreach ($committees as $committee)
                                <option value={{ $committee->id }}>{{ $committee->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12">
                        <label for="subject">Agenda Subject</label>
                        <textarea name="subject" name="subject" rows="4" class="form-control" required></textarea>
                    </div>
                    
                    <div class="col-6">
                        <div class="custom-file">
                            <input type="file" name="agenda" id="agenda" class="custom-file-input">
                            <label id="agenda-label" for="agenda" class="custom-file-label" >Upload Agenda</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="custom-file">
                            <input type="file" name="annexure" id="annexure" class="custom-file-input">
                            <label for="annexure" class="custom-file-label">Upload Annexure</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="custom-file">
                            <input type="file" name="notesheet" id="notesheet" class="custom-file-input">
                            <label for="notesheet" class="custom-file-label">Upload Notesheet</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="custom-file">
                            <input type="file" name="presentation" id="presentation" class="custom-file-input">
                            <label for="presentation" class="custom-file-label">Upload Presentation</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="custom-file">
                            <input type="file" name="supplementary" id="supplementary" class="custom-file-input">
                            <label for="supplementary" class="custom-file-label">Upload Supplementary</label>
                        </div>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-primary" type="submit">Create</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

    
@endsection