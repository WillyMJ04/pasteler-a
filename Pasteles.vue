
<template>
  <div>
    <h2>Gestión de Pasteles</h2>
    <form @submit.prevent="savePastel">
      <input v-model="nombre" placeholder="Nombre" required />
      <textarea v-model="descripcion" placeholder="Descripción"></textarea>
      <input v-model="preparadoPor" placeholder="Preparado por" />
      <input type="date" v-model="fechaCreacion" required />
      <input type="date" v-model="fechaVencimiento" required />
      <select v-model="estado">
        <option value="activo">Activo</option>
        <option value="inactivo">Inactivo</option>
      </select>
      <button type="submit">Guardar</button>
    </form>
    <ul>
      <li v-for="pastel in pasteles" :key="pastel.ID_pastel">
        {{ pastel.Nombre }} - {{ pastel.Descripcion }}
        <button @click="editPastel(pastel)">Editar</button>
        <button @click="deletePastel(pastel.ID_pastel)">Eliminar</button>
      </li>
    </ul>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      pasteles: [],
      nombre: '',
      descripcion: '',
      preparadoPor: '',
      fechaCreacion: '',
      fechaVencimiento: '',
      estado: 'activo',
      id: null,
    };
  },
  methods: {
    async fetchPasteles() {
      const response = await axios.get('/api.php?pasteles=true');
      this.pasteles = response.data;
    },
    async savePastel() {
      if (this.id) {
        await axios.put('/api.php?pasteles=true', {
          ID_pastel: this.id,
          Nombre: this.nombre,
          Descripcion: this.descripcion,
          Preparado_por: this.preparadoPor,
          Fecha_creacion: this.fechaCreacion,
          Fecha_vencimiento: this.fechaVencimiento,
          Estado: this.estado,
        });
      } else {
        await axios.post('/api.php?pasteles=true', {
          Nombre: this.nombre,
          Descripcion: this.descripcion,
          Preparado_por: this.preparadoPor,
          Fecha_creacion: this.fechaCreacion,
          Fecha_vencimiento: this.fechaVencimiento,
          Estado: this.estado,
        });
      }
      this.resetForm();
      this.fetchPasteles();
    },
    editPastel(pastel) {
      this.id = pastel.ID_pastel;
      this.nombre = pastel.Nombre;
      this.descripcion = pastel.Descripcion;
      this.preparadoPor = pastel.Preparado_por;
      this.fechaCreacion = pastel.Fecha_creacion;
      this.fechaVencimiento = pastel.Fecha_vencimiento;
      this.estado = pastel.Estado;
    },
    async deletePastel(id) {
      await axios.delete(`/api.php?pasteles=true&id=${id}`);
      this.fetchPasteles();
    },
    resetForm() {
      this.id = null;
      this.nombre = '';
      this.descripcion = '';
      this.preparadoPor = '';
      this.fechaCreacion = '';
      this.fechaVencimiento = '';
      this.estado = 'activo';
    },
  },
  mounted() {
    this.fetchPasteles();
  },
};
</script>
