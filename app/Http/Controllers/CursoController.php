<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\DB;
use App\Curso;
use App\Tema;
use App\DataTables\CursoDataTables;
use Validator;
use Yajra\Datatables\Datatables;

class CursoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CursoDataTables $dataTable)
    {
        return $dataTable->render('profesor.curso.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View('profesor.curso.crear_curso');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            //'curs_id' => 'required',
           'nombre_curso' => 'required',
           'introduccion_curso' => 'required'
        ]);
        //dd($request->all());
        Curso::create([
            'curs_nombre' => $request['nombre_curso'],
            'curs_introduccion'=> $request['introduccion_curso']
          ]);
          flash('Curso "'.$curso->curs_nombre.'" creado con éxito.', 'success');
        return redirect()->route('profesor.curso');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $curso = Curso::find($id);
        return View('profesor.curso.ver_curso')->with('curso', $curso);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $curso = Curso::find($id);
        return View('profesor.curso.editar_curso')->with('curso', $curso);
        //return $curso->curs_introduccion;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Validator::make($request->all(), [
            'nombre_curso' => 'required|max:100',
            'introduccion_curso' => 'required|max:500',
        ])->validate();
        $curso = Curso::find($id);
        $curso->curs_nombre = $request->input('nombre_curso');
        $curso->curs_introduccion = $request->input('introduccion_curso');
        $curso->save();
        flash('Curso "'.$curso->curs_nombre.'" editado con éxito.', 'success');
        return redirect()->route('profesor.curso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Curso::destroy($id);
        flash('Curso "'.$curso->curs_nombre.'" eliminado con éxito.', 'success');
        return redirect()->route('profesor.curso');
    }

    public function ver_temas_por_curso($curs_id = "")
    {
        $curso = Curso::find($curs_id);
        return View('profesor.curso.tema.ver_tema')->with('curso', $curso);
    }

    public function ver_temas_por_curso_ajax($curs_id = "")
    {
        $temas = Tema::where('curs_id', $curs_id)->get();
        return Datatables::of($temas)->make();
    }
}
