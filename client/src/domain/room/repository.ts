import * as firestore from './persistance/firestore';
import { Room } from './types';

export const create = async (item: Room, uid: string) =>
  firestore.create(item, uid);
